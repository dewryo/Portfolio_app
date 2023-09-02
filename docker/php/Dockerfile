# ベースイメージを指定
FROM php:8.2-fpm

# 必要なパッケージをインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libfontconfig1 \
    libxrender1

# GD拡張モジュールを有効化してインストール
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# その他のPHP拡張モジュールをインストール
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo_mysql mysqli exif

# Composerをインストール
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# Node.jsとNVMをインストール
ENV NODE_VERSION=16.16.0
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

# Node.jsとnpmのバージョンを確認
RUN node --version
RUN npm --version

# 作業ディレクトリを設定
WORKDIR /src

# ソースコードをコンテナ内にコピーし、ファイルの所有者をwww-dataに変更
ADD . /src/storage
RUN chown -R www-data:www-data /src/storage