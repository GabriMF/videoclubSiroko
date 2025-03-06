FROM php:8.3-fpm-alpine

ARG USER_UID
ARG USER_GID

# Update container
RUN apk -U upgrade

# Install dependencies
RUN apk add openssl curl wget icu-libs icu-dev libxml2 libxml2-dev

# Install utilities
RUN apk add zsh git neovim

# Install php modules
RUN apk add --no-cache $PHPIZE_DEPS \
    linux-headers \
    pcre \
    rabbitmq-c-dev \
    && docker-php-ext-install -j$(nproc) intl pdo_mysql opcache simplexml \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install amqp && docker-php-ext-enable amqp

# Create symbolic link for php if not exists
RUN [ -e /usr/bin/php ] || ln -s /usr/bin/php83 /usr/bin/php

# Install Composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer &&\
	composer self-update

# Install Symfony cli
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | sh
RUN apk add symfony-cli

# Define custom entrypoint
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install lefthook
RUN wget https://github.com/evilmartians/lefthook/releases/download/v1.6.1/lefthook_1.6.1_Linux_x86_64 -O /usr/local/bin/lefthook && chmod +x /usr/local/bin/lefthook
COPY ./.gitconfig /root/.gitconfig

# Select work directory
WORKDIR /app

# Add and config container user
RUN addgroup -g $USER_GID appgroup
RUN adduser -D -u $USER_UID -G appgroup -h /home/sirokouser sirokouser

COPY ./.zshrc /home/sirokouser/.zshrc-custom-alias-tmp

RUN chown -R $USER_UID:$USER_UID /home/sirokouser/ && chown $USER_UID:$USER_UID /entrypoint.sh
RUN chown -R $USER_UID:$USER_UID /usr/local/bin/lefthook
USER sirokouser
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)" -- \
    -a 'CASE_SENSITIVE="true"' \
    -t robbyrussell \
    -p https://github.com/zsh-users/zsh-autosuggestions \
    -p https://github.com/zsh-users/zsh-syntax-highlighting
RUN cat /home/sirokouser/.zshrc-custom-alias-tmp | xargs -I _ echo _ >> /home/sirokouser/.zshrc &&\
    rm /home/sirokouser/.zshrc-custom-alias-tmp
USER root
RUN mkdir /home/sirokouser/xdebug && touch /home/sirokouser/xdebug/xdebug.log && chown $USER_UID:$USER_UID -R /home/sirokouser/xdebug && chmod 777 /home/sirokouser/xdebug/xdebug.log

ENTRYPOINT ["/entrypoint.sh"]
