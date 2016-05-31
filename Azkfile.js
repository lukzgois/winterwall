/**
 * Documentation: http://docs.azk.io/Azkfile.js
 */
// Adds the systems that shape your system
systems({
  winterwall: {
    // Dependent systems
    depends: ["database", "mail"],
    // More images:  http://images.azk.io
    image: {"docker": "lukz/nginx-php-fpm"},
    // Steps to execute before running instances
    provision: [
    ],
    workdir: "/azk/#{manifest.dir}",
    shell: "/bin/bash",
    wait: 20,
    mounts: {
      '/azk/#{manifest.dir}': path("."),
    },
    scalable: {"default": 1},
    http: {
      domains: [ "#{system.name}.#{azk.default_domain}" ]
    },
    ports: {
      // exports global variables
      http: "80/tcp",
    },
    envs: {
      // Make sure that the PORT value is the same as the one
      // in ports/http below, and that it's also the same
      // if you're setting it in a .env file
      APP_DIR: "/azk/#{manifest.dir}",
    },
  },
  database: {
    // More info about postgres image: http://images.azk.io/#/postgres?from=images-azkfile-postgres
    image: {"docker": "azukiapp/postgres:9.5"},
    shell: "/bin/bash",
    wait: 20,
    mounts: {
      '/var/lib/postgresql/data': persistent("winterwall-dabatase"),
    },
    ports: {
      // exports global variables: "#{net.port.data}"
      data: "5432/tcp",
    },
    envs: {
      // set instances variables
      POSTGRES_USER: "azk",
      POSTGRES_PASS: "azk",
      POSTGRES_DB  : "winterwall",
    },
    export_envs: {
      // check this gist to configure your database
      // Ruby eg in: https://gist.github.com/gullitmiranda/62082f2e47c364ef9617
      // DATABASE_URL: "postgres://#{envs.POSTGRES_USER}:#{envs.POSTGRES_PASS}@#{net.host}:#{net.port.data}/#{envs.POSTGRES_DB}",
      // Exlir eg in: https://github.com/azukiapp/hello_phoenix/blob/master/config/database.uri.exs
      // DATABASE_URL: "ecto+postgres://#{envs.POSTGRES_USER}:#{envs.POSTGRES_PASS}@#{net.host}:#{net.port.data}/#{envs.POSTGRES_DB}",
      // or use splited envs:
      DATABASE_ENV_USER: "#{envs.POSTGRES_USER}",
      DATABASE_ENV_PASSWORD: "#{envs.POSTGRES_PASS}",
      DATABASE_ENV_DB  : "#{envs.POSTGRES_DB}",
    },
  },
  // MailCatcher system
  mail: {
    // Dependent systems
    depends: [],
    // More images:  http://images.azk.io
    image: {"docker": "schickling/mailcatcher"},
    http: {
      domains: [
        "#{system.name}.#{azk.default_domain}",
      ],
    },
    ports: {
      // exports global variables
      http: "1080/tcp",
      smtp: "1025/tcp",
    }
  },
});
