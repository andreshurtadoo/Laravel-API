# API de Usuarios

## GET Usuarios - Obtener todos los Usuarios

### Endpoint

```http
GET http://127.0.0.1:8000/api/user
```

### Ejemplo de Respuesta del Servidor
```json
[
    {
        "id": 11,
        "cedula": "29626410",
        "name": "Andres Eduardo",
        "lastname": "Hurtado Benites",
        "email": "hurtadoandres2002@gmail.com",
        "telephone": "04244116339",
        "state": "Carabobo",
        "city": "Valencia",
        "photo_url": "http://127.0.0.1:8000/storage/photos/o5BRI1KaQs523Gc0PJEmMOF0ZxeB3g2opJgGIQQZ.png",
        "status": 0,
        "rol": 0,
        "email_verified_at": null
    }
    // Otros usuarios
]
```

Utiliza el campo **photo_ulr** para que el servidor te devuelva la imagen del usuario**

## POST Usuarios - Crear un usuario

### Endpoint

```http
POST http://127.0.0.1:8000/api/user
```

#### Parámetros de la Solicitud

Envía los siguientes campos en el cuerpo de la solicitud como formulario o JSON:

- **cedula** (opcional, string): Número de cédula del usuario.
- **name** (obligatorio, string): Nombre del usuario.
- **lastname** (obligatorio, string): Apellido del usuario.
- **email** (obligatorio, string): Correo electrónico del usuario (debe ser único).
- **telephone** (opcional, string): Número de teléfono del usuario.
- **state** (opcional, string): Estado del usuario.
- **city** (opcional, string): Ciudad del usuario.
- **photo_url** (opcional, file): URL de la foto del usuario (formatos permitidos: jpeg, png, jpg, gif, tamaño máximo: 2MB).
- **status** (opcional, integer): Estado del usuario (0 o 1).
- **rol** (opcional, integer): Rol del usuario (0 o 1).

## GET Usuario - Obtener un usuario

### Endpoint

```http
GET http://127.0.0.1:8000/api/user/user_id
```

## UPDATE Usuario - Editar un usuario

### Endpoint

```http
PUT http://127.0.0.1:8000/api/user/user_id
```

Envía los mismos campos para crear un usuario en el cuerpo de la solicitud como formulario o JSON:

## DELETE Usuario - Eliminar un usuario

### Endpoint

```http
DELETE http://127.0.0.1:8000/api/user/user_id
```

# API de Videos

## GET Videos - Obtener todos los Videos

### Endpoint

```http
GET http://127.0.0.1:8000/api/videos
```

### Ejemplo de Respuesta del Servidor
```json
[
  {
    "id": 1,
    "name": "One Hundred Years of Solitude Official Teaser Netflix",
    "description": "Official Teaser Netflix",
    "user_id": 11,
    "folderName": "http://127.0.0.1:8000/storage/videos/9KvHaZuJHQjT9Qc9ZZqQLkypdKysI1mEyYDV2pP5.mp4",
    "created_at": "2024-07-05T00:24:20.000000Z",
    "updated_at": "2024-07-05T00:24:20.000000Z",
    "likes_count": 2,
    "dislikes_count": 1,
    "user": {
      "id": 11,
      "cedula": "29626410",
      "name": "Andres Eduardo",
      "lastname": "Hurtado Benites",
      "email": "hurtadoandres2002@gmail.com",
      "telephone": "04244116339",
      "state": "Carabobo",
      "city": "Valencia",
      "photo_url": "/storage/photos/o5BRI1KaQs523Gc0PJEmMOF0ZxeB3g2opJgGIQQZ.png",
      "status": 0,
      "rol": 0,
      "email_verified_at": null
    },
    "likes": [
      {
        "id": 2,
        "user_id": 1,
        "video_id": 1,
        "created_at": "2024-07-05T14:06:19.000000Z",
        "updated_at": "2024-07-05T14:06:19.000000Z"
      },
      {
        "id": 3,
        "user_id": 3,
        "video_id": 1,
        "created_at": "2024-07-05T14:06:43.000000Z",
        "updated_at": "2024-07-05T14:06:43.000000Z"
      }
    ],
    "dislikes": [
      {
        "id": 1,
        "user_id": 11,
        "video_id": 1,
        "created_at": "2024-07-05T14:05:47.000000Z",
        "updated_at": "2024-07-05T14:05:47.000000Z"
      }
    ],
    "comments": [
      {
        "id": 1,
        "user_id": 11,
        "video_id": 1,
        "comment": "Wow increible, espero verla pronto",
        "created_at": "2024-07-05T14:24:13.000000Z",
        "updated_at": "2024-07-05T14:24:13.000000Z"
      }
    ]
  }
]
```
En la respuesta json podemos ver los siguientes arreglos:
- **User** Contiene la informacion del usuario al que le pertence el video.
- **Likes/Dislikes** Contiene la informacion de los usuarios que le han dado like al video, lo mismo para dislike.
- **Comments** Contiene los comentarios que tiene el video y por que usuario fue hecho.

Utiliza el campo **folderName** para que el servidor te devuelva el video mp4

## POST Videos - Crear un Video

### Endpoint

```http
POST http://127.0.0.1:8000/api/videos
```

#### Parámetros de la Solicitud

Envía los siguientes campos en el cuerpo de la solicitud como formulario o JSON:

- **name** (obligatorio, string): Nombre del video.
- **description** (opcional, string): Descripción del video.
- **user_id** (obligatorio, integer): ID del usuario que sube el video (debe existir en la base de datos).
- **video** (obligatorio, file): Archivo de video (formatos permitidos: mp4, mov, ogg, qt, tamaño máximo: 20MB).

#### Ejemplo de Solicitud (FormData)

## GET Video - Obtener un video

### Endpoint

```http
GET http://127.0.0.1:8000/api/videos/user_id
```

## UPDATE Video - Editar un video

### Endpoint

```http
PUT http://127.0.0.1:8000/api/videos/user_id
```

Envía los mismos campos para crear un video en el cuerpo de la solicitud como formulario o JSON:

## DELETE Video - Eliminar un video

### Endpoint

```http
DELETE http://127.0.0.1:8000/api/videos/user_id
```

# API de Email

### Endpoint para enviar un email

```http
POST http://127.0.0.1:8000/api/send-email
```

#### Parámetros de la Solicitud

Envía los siguientes campos en el cuerpo de la solicitud como formulario o JSON:

- **to** (string): Direccion email a donde queremos enviar el correo.
- **body** (string): Contenido o cuerpo del email.

### Respuesta del servidor

```json
{
  "message": "Email sent successfully"
}
```

# API de Likes

### Endpoint para darle like a un video

```http
POST http://127.0.0.1:8000/api/videos/video_id/likes/user_id
```

- **Importante** En la url debe ir el **id del video** y el **id del usuario**

### Respuesta del servidor

```json
{
  "video_id": 1,
  "user_id": 11,
  "updated_at": "2024-07-05T16:20:34.000000Z",
  "created_at": "2024-07-05T16:20:34.000000Z",
  "id": 4
}
```

# API de Dislike

### Endpoint para darle dislike a un video

```http
POST http://127.0.0.1:8000/api/videos/video_id/dislikes/user_id
```

- **Importante** En la url debe ir el **id del video** y el **id del usuario**

### Respuesta del servidor

```json
{
  "video_id": 1,
  "user_id": 11,
  "updated_at": "2024-07-05T16:22:31.000000Z",
  "created_at": "2024-07-05T16:22:31.000000Z",
  "id": 2
}
```

- **Nota** Un usuario no puede darle like y dislike al mismo video, si da un like y luego un dislike, el like anterior se quita

# API de comentarios

### Endpoint para hacer un comentario a un video

```http
POST http://127.0.0.1:8000/api/videos/video_id/comments/user_id
```

- **Importante** En la url debe ir el **id del video** y el **id del usuario**

#### Parámetros de la Solicitud

Envía los siguientes campos en el cuerpo de la solicitud como formulario o JSON:

- **comment** (string): Comentario que se le va hacer al video.

### Respuesta del servidor

```json
{
  "comment": "Esto es un comentario de prueba",
  "user_id": 11,
  "video_id": 1,
  "updated_at": "2024-07-05T16:28:25.000000Z",
  "created_at": "2024-07-05T16:28:25.000000Z",
  "id": 2
}
```
