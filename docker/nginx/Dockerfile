FROM nginx:1.11.6

COPY nginx.conf /etc/nginx/
COPY web.conf   /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server app:9000; }" > /etc/nginx/conf.d/upstream.conf

VOLUME /app

EXPOSE 80

CMD ["nginx"]
