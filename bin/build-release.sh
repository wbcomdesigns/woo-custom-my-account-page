#!/usr/bin/env bash
#
# Portable Wbcom plugin release builder.
#
# The SAME script across every plugin. It discovers the plugin's own slug, main
# file, version and version constant, so uniformity does not depend on anyone
# editing per-plugin variables. Gates that need a config (WPCS, build freshness)
# run when that config is present and are skipped, loudly, when it is not.
#
# The assertions run against the ARTIFACT, by name, and delete the zip if any
# of them fails - two real Wbcom releases shipped a broken zip that passed every
# dev-tree gate (a stripped bundled SDK, a stale production bundle), so "the
# source is fine" is not proof the package is.
set -euo pipefail

cd "$( dirname "$0" )/.."

SLUG="$( basename "$PWD" )"

# --- Discover the main file (the one carrying the plugin header). -----------
MAIN_FILE=""
for f in *.php; do
	[ -f "$f" ] || continue
	if grep -qiE '^[[:space:]]*\*?[[:space:]]*Plugin Name:' "$f"; then MAIN_FILE="$f"; break; fi
done
if [ -z "$MAIN_FILE" ]; then
	echo "build-release: could not find the plugin main file (no 'Plugin Name:' header)" >&2
	exit 1
fi

VERSION="$( grep -m1 -iE '^[[:space:]]*\*?[[:space:]]*Version:' "$MAIN_FILE" | grep -oE '[0-9]+\.[0-9]+(\.[0-9]+)?([-.][0-9A-Za-z]+)*' | head -1 )"
if [ -z "$VERSION" ]; then
	echo "build-release: no Version in $MAIN_FILE header" >&2
	exit 1
fi

DIST="dist"
STAGE="$DIST/$SLUG"
ZIP="$DIST/$SLUG-$VERSION.zip"

# --- Gate 1: the version must agree everywhere it is written down. ----------
# A mismatch here is what makes WordPress offer an update that never applies.
fail=0

CONST_NAME="$( grep -rhoE "define\( *'[A-Z0-9_]*VERSION'" "$MAIN_FILE" 2>/dev/null | grep -oE "'[A-Z0-9_]*VERSION'" | tr -d "'" | head -1 )"
if [ -n "$CONST_NAME" ]; then
	CONST_VERSION="$( grep -m1 "define( '$CONST_NAME'" "$MAIN_FILE" | sed "s/.*'\([0-9][0-9A-Za-z.\-]*\)'.*/\1/" )"
	[ "$CONST_VERSION" = "$VERSION" ] || { echo "build-release: version mismatch - header $VERSION, $CONST_NAME $CONST_VERSION" >&2; fail=1; }
fi

README="$( ls -1 2>/dev/null | grep -iE '^readme\.txt$' | head -1 )"
if [ -n "$README" ]; then
	README_VERSION="$( grep -m1 -i "^Stable tag:" "$README" | awk '{print $3}' )"
	[ -z "$README_VERSION" ] || [ "$README_VERSION" = "$VERSION" ] || { echo "build-release: version mismatch - header $VERSION, readme $README_VERSION" >&2; fail=1; }
fi

if [ -f package.json ]; then
	PKG_VERSION="$( node -p "require('./package.json').version" 2>/dev/null || echo "$VERSION" )"
	[ "$PKG_VERSION" = "$VERSION" ] || { echo "build-release: version mismatch - header $VERSION, package.json $PKG_VERSION" >&2; fail=1; }
fi
[ "$fail" -eq 0 ] || exit 1
echo "build-release: version $VERSION agrees across every file that records it"

# --- Gate 2: PHP must parse. -----------------------------------------------
find . -name '*.php' -not -path './node_modules/*' -not -path './vendor/*' -not -path './dist/*' -not -path './.git/*' \
	-print0 | xargs -0 -n1 -P4 php -l > /dev/null
echo "build-release: PHP lint clean"

# --- Gate 3: coding standards, when a ruleset is committed. -----------------
PHPCS_RULESET="$( ls phpcs.xml.dist phpcs.xml 2>/dev/null | head -1 || true )"
if [ -n "$PHPCS_RULESET" ]; then
	PHPCS_BIN=""
	for c in "vendor/bin/phpcs" "$HOME/.composer/vendor/bin/phpcs" "$( command -v phpcs || true )"; do
		[ -x "$c" ] && { PHPCS_BIN="$c"; break; }
	done
	if [ -n "$PHPCS_BIN" ]; then
		"$PHPCS_BIN" -q --report=summary >/dev/null && echo "build-release: WPCS clean"
	else
		echo "build-release: phpcs not installed, coding-standard gate SKIPPED" >&2
	fi
fi

# --- Gate 4: shipped bundles must match their sources, when checked. --------
if [ -f bin/verify-build-freshness.sh ]; then
	bash bin/verify-build-freshness.sh
fi

# --- Stage, honouring .distignore. -----------------------------------------
if [ ! -f .distignore ]; then
	echo "build-release: .distignore missing - refusing to guess what ships" >&2
	exit 1
fi
rm -rf "$STAGE"
mkdir -p "$STAGE"

EXCLUDES=()
while IFS= read -r line; do
	[ -z "$line" ] && continue
	case "$line" in \#*) continue ;; esac
	EXCLUDES+=( --exclude "$line" )
done < .distignore

rsync -a "${EXCLUDES[@]}" --exclude "/$DIST" ./ "$STAGE/"

# Sweep OS metadata as a second guard behind the .distignore rule.
find "$STAGE" \( -name '.DS_Store' -o -name 'Thumbs.db' \) -delete

( cd "$DIST" && zip -qr "$SLUG-$VERSION.zip" "$SLUG" )

# --- Gate 5: the artifact must contain what the plugin needs to run. --------
# Named files, on the ARTIFACT. Any bundled SDK's own src/ is asserted too, so
# an unanchored exclude that strips it fails the build instead of the customer.
ZIP_CONTENTS="$( unzip -Z1 "$ZIP" )"
REQUIRED=( "$SLUG/$MAIN_FILE" )
[ -n "$README" ] && REQUIRED+=( "$SLUG/$README" )
# Here-strings, not pipes: `grep -q` exits on the first match and a piped
# upstream then takes SIGPIPE, which under `set -o pipefail` reports the whole
# pipeline as failed for a file that is actually present.
for srcdir in libs/*/src; do
	[ -d "$srcdir" ] || continue
	if ! grep -qE "^$SLUG/$srcdir/.*\.php$" <<<"$ZIP_CONTENTS"; then
		echo "build-release: FAILED - bundled library source missing from zip: $srcdir" >&2
		rm -f "$ZIP"; exit 1
	fi
done
for f in "${REQUIRED[@]}"; do
	if ! grep -qxF "$f" <<<"$ZIP_CONTENTS"; then
		echo "build-release: FAILED - required file missing from zip: $f" >&2
		rm -f "$ZIP"; exit 1
	fi
done

# --- Gate 6: dev artefacts must NOT be in the artifact. ---------------------
LEAKED="$( printf '%s\n' "$ZIP_CONTENTS" | grep -E "/(node_modules|\.git|bin|dist)/|/(CLAUDE\.md|package\.json|package-lock\.json|Gruntfile\.js|gruntfile\.js|\.distignore)$" || true )"
if [ -n "$LEAKED" ]; then
	echo "build-release: FAILED - dev artefacts leaked into the zip:" >&2
	printf '%s\n' "$LEAKED" >&2
	rm -f "$ZIP"; exit 1
fi

SIZE="$( du -h "$ZIP" | cut -f1 | tr -d ' ' )"
COUNT="$( printf '%s\n' "$ZIP_CONTENTS" | grep -c . )"
echo "build-release: OK - $ZIP ($SIZE), $COUNT files"
