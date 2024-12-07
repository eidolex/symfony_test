FROM node:20-bookworm as base

WORKDIR /app

COPY ["./frontend/package.json", "./frontend/package-lock.json", "./"]

RUN npm install

COPY ./frontend .

FROM base as build

WORKDIR /app

RUN npm run generate

FROM nginx:1.21-alpine as final

COPY --from=build /app/.output/public /usr/share/nginx/html

EXPOSE 80