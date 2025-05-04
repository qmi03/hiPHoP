= Installation <installation>

This chapter details the steps to setup environment and install the application.

== Environment requirements

- PHP >= 8.0
- mysql >= 8.0
- apache >= 2.4.0
- npm >= 18.0
- gnumake

== Build steps

Run the following commands in the source code directory:

```bash
npm install
make build
php migrations/script.php run
```

== Installation steps

Copy the source code directory to the webroot directory. The application should be available on `localhost:127.0.0.1` by now.
