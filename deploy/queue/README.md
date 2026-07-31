# Queue worker deployment

Login email and SMS notifications use the database queue. Each installed ZJMF
instance needs its own worker because queue connections are loaded from that
instance's `app/config/database.php`.

Install a worker with automatic service-manager detection:

```sh
./bin/install-queue-service \
  --root /var/www/zjmf \
  --php /usr/bin/php \
  --user www-data
```

The installer supports systemd, Supervisor and OpenRC. Use `--manager` when a
host has more than one service manager. Service definitions execute PHP
directly so they also work with hosting security policies that reject child
processes launched by a shell. The project-local `bin/zjmf-queue-worker`
launcher remains available for containers and low-volume cron fallbacks.
On systemd hosts, the installer first uses the native service user directive.
If that process cannot remain active, it automatically retries through
`runuser`; this keeps PHP under the configured unprivileged account while
working around hosting security products that reject systemd's user transition.

Container deployments should run the launcher as a separate foreground
process. Hosts without a service manager may schedule
`bin/zjmf-queue-worker --once`, but each invocation processes at most one job
and is intended only as a low-volume fallback.

After application code changes, restart the service so a daemon worker loads
the new PHP files.
