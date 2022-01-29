ARG UBUNTU_IMAGES
FROM ${UBUNTU_IMAGES}

WORKDIR /var/www/html

#设置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# USER root

# 修改apk 源
RUN sed -i 's/security.ubuntu/mirrors.aliyun/g' /etc/apt/sources.list
RUN sed -i 's/archive.ubuntu/mirrors.aliyun/g' /etc/apt/sources.list

# Libs
RUN apt-get update \
    && apt-get install -y \
    cron \
    netcat \
	vim \
    curl \
    wget \
    git \
    gcc \
    zip \
    libc6-dev \
    lrzsz
