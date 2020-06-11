FROM ubuntu:18.04
MAINTAINER arryuu<604125002@qq.com>

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

ENV APATH=/arryuu
RUN mkdir $APATH

WORKDIR $APATH

RUN mkdir $APATH/www

#COPY ./go1.14.2.linux-amd64.tar.gz $APATH
#RUN tar -zxvf $APATH/go1.14.2.linux-amd64.tar.gz -C /usr/local/

ENV GONAME=go1.14.4.linux-amd64.tar.gz
ADD https://dl.google.com/go/$GONAME $APATH
RUN tar -zxvf $APATH/$GONAME -C /usr/local/

ENV WPATH=/www
RUN mkdir -p $WPATH/golang/src

ENV GOPATH=/www/golang
ENV GOROOT=/usr/local/go
ENV GOARCH=386
ENV GOOS=linux
ENV GOTOOLS=$GOROOT/pkg/tool
ENV PATH=$PATH:$GOROOT/bin:$GOPATH/bin

RUN go env -w GO111MODULE=on
RUN go env -w GOPROXY=https://goproxy.cn,direct

#RUN yum install -y java-1.8.0-openjdk
#RUN echo $JAVA_HOME && java -version
# mycat
#COPY ./mycat2-1.01-SNAPSHOT.tar.gz $APATH
#RUN tar -xf $APATH/mycat2-1.01-SNAPSHOT.tar.gz
#ENV MYCAT_HOME=$APATH/mycat
#WORKDIR $MYCAT_HOME/bin
#RUN chmod u+x $APATH/mycat

# RUN mkdir -p /run/systemd && echo 'docker' > /run/systemd/container

# CMD ["/bin/bash"]
# 定制工作目录
#WORKDIR /root/go/src/myTest/
#对外端口
#EXPOSE 8080
#运行
#ENTRYPOINT ["go","run","test.go"]