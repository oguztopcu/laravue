# Proje Adı

Proje adı, amacınızı ve belki kısa bir açıklama içerebilir.

## Gereksinimler

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Kurulum

1. Depoyu klonlayın:

    ```bash
    git clone https://github.com/oguztopcu/laravue.git
    ```

2. Proje dizinine gidin:

    ```bash
    cd <project-name>
    ```

3. `.env.example` dosyasını kopyalayıp `.env` olarak adlandırın ve gerekli ayarları yapın:

    ```bash
    cp .env.example .env
    ```

    Ardından, `.env` dosyasını bir metin düzenleyiciyle açın ve veritabanı ayarlarını güncelleyin.

4. Docker konteynerlerini başlatın:

    ```bash
    docker-compose up -d
    ```

    Bu komut, Laravel uygulamanızı ve bağımlılıklarını Docker konteynerlerinde başlatır.

5. Uygulamayı başlatın:

    ```bash
    docker-compose exec php php artisan key:generate
    ```

6. Veritabanını oluşturun ve tabloları göç edin:

    ```bash
    docker-compose exec php php artisan migrate
    ```

7. Uygulamayı kullanmaya başlayın:

    Tarayıcıda `http://localhost` adresine giderek uygulamayı görüntüleyebilirsiniz.

## Docker Konteynerlerini Kapatma

Docker konteynerlerini kapatmak için:

```bash
docker-compose down
