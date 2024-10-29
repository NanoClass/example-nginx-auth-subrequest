## Nginx Authentication Implementation Using Subrequest Authentication

For detailed examples of implementing Nginx authentication via subrequest authentication, refer to the official documentation: [Nginx Subrequest Authentication](https://docs.nginx.com/nginx/admin-guide/security-controls/configuring-subrequest-authentication/).

### Build and Run

To build the project for the first time, execute:

```bash
docker-compose build --no-cache
```

Next, start the application in detached mode with:

```bash
docker-compose up -d
```

### Adding Users

To add additional users, run the following command:

```bash
docker-compose exec auth-server php /init-user.php user password
```

---

### © NanoClass 2024