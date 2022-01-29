ARG LEAF_SERVER_IMAGES
FROM ${LEAF_SERVER_IMAGES}

#设置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list
RUN sed -i 's/security.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list

RUN apt update \
    && apt install maven -y \
    && apt install default-jdk -y \
    vim

ENV JAVA_HOME /usr/lib/jvm/java-11-openjdk-amd64
ENV PATH $JAVA_HOME/bin:$PATH
ENV CLASSPATH .:$JAVA_HOME/lib

RUN mkdir /leaf

ADD leaf/ leaf/

WORKDIR /leaf

#EXPOSE 8080

RUN chmod +x /leaf/leaf-server/deploy/run.sh
CMD ["/leaf/leaf-server/deploy/run.sh"]