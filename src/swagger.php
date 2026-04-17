<!DOCTYPE html>
<html>
    <head>
        <title>Desafio técnico Tecnofit - Ranking de Movimento</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css" />
    </head>
    <body>
        <div id="swagger"></div>
        <script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
        <script>
        SwaggerUIBundle({
            url: "/openapi.json",
            dom_id: "#swagger"
        });
        </script>
    </body>
</html>