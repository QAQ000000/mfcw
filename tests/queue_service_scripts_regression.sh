#!/bin/sh

set -eu

ROOT=$(CDPATH= cd -P "$(dirname "$0")/.." && pwd)
PHP_BIN=$(command -v php)

sh -n "$ROOT/bin/zjmf-queue-worker"
sh -n "$ROOT/bin/install-queue-service"
sh -n "$ROOT/deploy/queue/openrc.init.in"

if sed -n '1,40p' "$ROOT/bin/zjmf-queue-worker" | grep -q 'dirname'; then
	echo "queue worker startup must not invoke external dirname" >&2
	exit 1
fi

PHP_BIN=$PHP_BIN "$ROOT/bin/zjmf-queue-worker" --check >/dev/null

for invalid_memory in 0 00 0128; do
	if PHP_BIN=$PHP_BIN QUEUE_MEMORY=$invalid_memory "$ROOT/bin/zjmf-queue-worker" --check >/dev/null 2>&1; then
		echo "QUEUE_MEMORY=$invalid_memory must be rejected" >&2
		exit 1
	fi
done
PHP_BIN=$PHP_BIN QUEUE_MEMORY=1 "$ROOT/bin/zjmf-queue-worker" --check >/dev/null

for manager in systemd supervisor openrc; do
	output=$(
		"$ROOT/bin/install-queue-service" \
			--root "$ROOT" \
			--php "$PHP_BIN" \
			--user "$(id -un)" \
			--manager "$manager" \
			--name test-zjmf-queue \
			--dry-run
	)
	printf '%s\n' "$output" | grep -q "manager=$manager"
	printf '%s\n' "$output" | grep -q 'queue:work'
	printf '%s\n' "$output" | grep -q "$PHP_BIN"
	if printf '%s\n' "$output" | grep -q '@[A-Z_][A-Z_]*@'; then
		echo "unrendered placeholder in $manager service definition" >&2
		exit 1
	fi
done

systemd_output=$(
	"$ROOT/bin/install-queue-service" \
		--root "$ROOT" \
		--php "$PHP_BIN" \
		--user "$(id -un)" \
		--manager systemd \
		--name test-zjmf-queue \
		--dry-run
)
printf '%s\n' "$systemd_output" | grep -q "User=$(id -un)"
printf '%s\n' "$systemd_output" | grep -q "ExecStart=$PHP_BIN"

openrc_output=$(
	"$ROOT/bin/install-queue-service" \
		--root "$ROOT" \
		--php "$PHP_BIN" \
		--user "$(id -un)" \
		--manager openrc \
		--name test-zjmf-queue \
		--dry-run
)
printf '%s\n' "$openrc_output" | grep -q 'respawn_max=3'
printf '%s\n' "$openrc_output" | grep -q 'respawn_period=10'
grep -q '整个 `bin/` 与' "$ROOT/README.md"

echo "queue service script regression passed"
