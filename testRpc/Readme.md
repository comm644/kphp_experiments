This test describes how to use databse with KPHP via gate.

Start HTTP gate:

```bash
php server-http.php
```

Build and run.

```bash
kphp -M cli client.php -I . && kphp_out/cli --Xkphp-options --disable-sql.
```

Preconditions:
1. Create Sqite databse according Database\Document schema. (use generator from https://github.com/comm644/temis.sql )
2. 
