var gsm = process.argv[2];

const takeRight = (arr, n = 1) => n === 0 ? [] : arr.slice(-n);

let content = takeRight(process.argv, process.argv.length - 3).join(" ");

const fastify = require('fastify')({ logger: true })
var admin = require("firebase-admin");

var serviceAccount = {
    "type": "service_account",
    "project_id": "test-app-fcm-sms",
    "private_key_id": "41f167455e68228a17335301b77e126f73eee6f5",
    "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCnWHwh7PUDEkMq\nEtEdvIy8gEogYOHNkhHI0busLe0OHarucQaa+BQIzTNIrMzWv73RLEpv2jkHBkQB\n4jBmENA/ViqlmkfgrlnV0HRFgH3eAyRu072zCEfJWRIhsc7/PX7794WCMmIhl16u\nC5Rr78GYUN8h71WCYqZ5RfdY9oXti824BAFm8s40fFL5+tQQ1sNbKrf2u8hRzXqw\nc+PuJQSCEFkUSZbcdfpOsQc7TC3WJYcGRRIRXuSTnKVYvnf0qCAfnZM+dgh3PjVU\nFvvTEtbFnQywiY/eG1+9PhPdvhmeP59pRlK+0w4/RcL5yMam4NKGhfUSG2igODYJ\nmg/yS6blAgMBAAECggEABURo79HbKmQVHq7Tpy4rwCJJ4LgFE3IlwroI90GgzdyU\nw9BlWVQRe6ZLhN3dOq1znUM1Q7q6ulrx6uYd5Ev1Cgy9eVOgVIvheUZ2Cm0htspH\nPoDqp2uWg/5BEzP/v9x8TTj8dbjZQSePC/3LvoGyUb6l5igu1p20JCExSKjFw6vq\ngmoUCGqHZ1G5PWBrD2GyBORhV8OONzbMYq6+5y4g5uk4Ea5cVvbcKZRtgu34W1Ek\nsROstuthIwLkv7sIEgFKGm0kL6gmh7LHTzo705Lq/nOtALZ+6HiI81IQydRXhqDa\nXC1r50tzc7DcdoWHTgtrznOvAdG6b0hm+qDQsHrtZwKBgQDm+FjZpIHZ/gce9w1D\niFeWBeOshsDJbzX46MKT0MLdEypZEH2j1NSseyJhHSttZqUfNqR2UlQV8dahuiso\nohVCdNwqrvg+Uqn2GE6fVZN4x52GdBXV2Gc/EK4/8SWGGgv5L9g2XCTXVSaV6SQV\nfDw2mvNfhxjiDIGdqJRMMwFUBwKBgQC5ewvAD/1dVHdiqYATxX0iAI/61XvKo6tZ\n6x3txYOLqPbPTHWdW5IPFyWy4fUexayRV0ES/Vt8SymwyEZoZVk5Tww4aBdD7y0S\nPrzyJelsYLg0pIf8I28Aqg9d3HJBQcJTeENCI7K0b+A8d+zu6r7m8q7nFn3GFx2G\nVfejsRVqswKBgQDHxfSrwwNhdrvYB52cVNhU9aEYP7GOSTeopEJwMbfqGcKeKIpT\nYynUSejRkLZYONkHZ27WvJzoIjYfynO8AH1c7tDjxlUHKt7A8gNHA3C7ngRdIBkm\nzrd2r8nXmo93Lx4+GSjs08Q1z/vA3FeOkddO77UjYimek2yk3gPu6Ir0jwKBgB4s\n3H6Em22hnkKY3NNan772ZHYkYR1YfzoDvDzAk2QXOwACqmfNS/fUhjeR9zToZ+jF\nTzrtqQKRn9i43GuDgX6HU6+hj5dnw+dh+Y9Th6QwIAfAdLcadKahBBr7EEN5lUnL\nGPYbpKkiQlLUF+HOovwjozzJNfESNaVzOvSQjLFtAoGBAKXcOOrzx0dfoMkve7t3\n+KaVeM2iviJb1mnal5JUN/ToFyN5hujPBrCH5lSI4mk579W5Cgiop0rvZbCRd2fq\nJjbJpUUYKvLMvvDv3IVHpFp6Pz2TfJfObJY2bImTgx0qdQu3MVmETqIIXTYqfbKI\nnH2HiD7e4eiYieAxAH73YIYm\n-----END PRIVATE KEY-----\n",
    "client_email": "firebase-adminsdk-ub4p5@test-app-fcm-sms.iam.gserviceaccount.com",
    "client_id": "113991252284037417778",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-ub4p5%40test-app-fcm-sms.iam.gserviceaccount.com",
    "universe_domain": "googleapis.com"
};


var app = admin.initializeApp({
    credential: admin.credential.cert(serviceAccount)
});

const registrationToken = 'eXM9TWdATgiYSDpufBIp_S:APA91bG_k31YiMJSkG_HkNK6IyquRf9RLrtaAi0hkRi3gyK1Ii4seeyJQviVR79HenzSmT127L9SMp0YOhErxt71mvcbR10DXAg2KZwOgdBVayOb5T3yBedXQnFv8AMaFk2mDBLn4CKY';
// 'eXM9TWdATgiYSDpufBIp_S:APA91bG_k31YiMJSkG_HkNK6IyquRf9RLrtaAi0hkRi3gyK1Ii4seeyJQviVR79HenzSmT127L9SMp0YOhErxt71mvcbR10DXAg2KZwOgdBVayOb5T3yBedXQnFv8AMaFk2mDBLn4CKY' // Ergün
// 'fiVQr4z0TQKNqsXuLabk7r:APA91bE5gcu6AcmXyckoJMQKKPiY5BPE8XQ1kpDZRRVqc6UTWDQRop8u3jNDyPuK_nUuQAjOSnXP5LH9E-9j-AO05QUSHKfkEZaBnHSx_3lLyuaLksJ_FlHfq3LPc7qC5xQB3EKItAaQ' // Batum

const message = {
    token: registrationToken,
    data: {
        phone: gsm,
        message: content
    },
    // Set Android priority to "high"
    android: {
        priority: "high",
    },
    // Add APNS (Apple) config
    apns: {
        payload: {
            aps: {
                contentAvailable: true,
            },
        },
        headers: {
            "apns-push-type": "background",
            "apns-priority": "5", // Must be `5` when `contentAvailable` is set to true.
            "apns-topic": "io.flutter.plugins.firebase.messaging", // bundle identifier
        },
    },
};

admin.messaging().send(message)
    .then((response) => {
        // Response is a message ID string.
        console.log('Successfully sent message:', response);
    })
    .catch((error) => {
        console.log('Error sending message:', error);
    });

