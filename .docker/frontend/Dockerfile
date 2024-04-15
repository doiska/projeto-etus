FROM node:18-alpine

RUN mkdir -p /app
WORKDIR /app

COPY ./web/package*.json /app/
RUN npm install

EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host"]
