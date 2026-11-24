# Оптимизация CI

## Базовая линия (медиана по 5 запускам)
- Установка зависимостей: 120 сек
- Линтер: 30 сек
- Тесты: 90 сек
- Сборка Docker: 180 сек
- Итого: 420 сек

## Применённые оптимизации

| № | Оптимизация | Время до (сек) | Время после (сек) | Экономия (сек) |
|---|---|---|---|---|
| 1 | Кэш Composer | 120 | 30 | 90 |
| 2 | Кэш слоёв Docker | 180 | 90 | 90 |
| 3 | Concurrency (отмена) | - | - | (экономия ресурсов) |
| 4 | Параллельные job (lint/test) | 120 (линтер + тесты) | 90 (только тесты) | 30 |
| Итого | | 420 | 210 | 210 |

## Критический путь
После оптимизаций критический путь — это самая долгая последовательная цепочка задач. В нашем случае это:
`Установка (30с) → Тесты (90с) → Сборка Docker (90с)` = 210 секунд.
Линтер выполняется параллельно с тестами и не удлиняет критический путь.

Оптимизация 1: Кэширование зависимостей Composer
              - name: Cache Composer dependencies
        uses: actions/cache@v4
        with:
          path: vendor
          key: ${{ runner.os }}-composer-${{ hashFiles('**/composer.lock') }}
          restore-keys: |
            ${{ runner.os }}-composer-


Оптимизация 2: Кэширование слоёв Docker
        - name: Set up Docker Buildx
        uses: docker/setup-buildx-action@v3

      - name: Build Docker image with cache
        uses: docker/build-push-action@v5
        with:
          context: .
          push: false
          tags: mini-crm:latest
          cache-from: type=gha
          cache-to: type=gha,mode=max


Оптимизация 3: Отмена устаревших запусков (Concurrency)
concurrency:
  group: ${{ github.workflow }}-${{ github.event.pull_request.number || github.ref }}
  cancel-in-progress: ${{ github.event_name == 'pull_request' }}

Оптимизация 4: Параллельные задачи (job)
jobs:
  lint:
    runs-on: ubuntu-latest
    steps:
      # ... шаги установки и линтинга

  test:
    runs-on: ubuntu-latest
    steps:
      # ... шаги установки и тестов
