#!/usr/bin/env bash
set -euo pipefail

# One-shot bootstrap for turning this repo into a full Laravel app in-place.
# Usage:
#   bash scripts/init-full-laravel-app.sh

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
TMP_DIR="${ROOT_DIR}/.tmp-laravel"

if [[ -f "${ROOT_DIR}/artisan" || -f "${ROOT_DIR}/composer.json" ]]; then
  echo "A Laravel app already appears to be initialized here (artisan/composer.json found)."
  echo "Skipping bootstrap."
  exit 0
fi

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer is required but not found in PATH."
  exit 1
fi

echo "Creating fresh Laravel skeleton in temporary directory..."
rm -rf "${TMP_DIR}"
composer create-project laravel/laravel "${TMP_DIR}" --no-interaction

# Preserve custom scaffold folders already present in this repo.
KEEP_PATHS=(
  "app"
  "config"
  "database"
  "docs"
  "docker"
  "resources"
  "routes"
  "Dockerfile"
  "docker-compose.yml"
  "README.md"
  "scripts"
  ".git"
)

BACKUP_DIR="${ROOT_DIR}/.tmp-preserve"
rm -rf "${BACKUP_DIR}"
mkdir -p "${BACKUP_DIR}"

for path in "${KEEP_PATHS[@]}"; do
  if [[ -e "${ROOT_DIR}/${path}" ]]; then
    mkdir -p "${BACKUP_DIR}/$(dirname "${path}")"
    cp -a "${ROOT_DIR}/${path}" "${BACKUP_DIR}/${path}"
  fi
done

echo "Copying Laravel skeleton into repository root..."
shopt -s dotglob
for item in "${TMP_DIR}"/*; do
  name="$(basename "${item}")"
  [[ "${name}" == "." || "${name}" == ".." ]] && continue
  rm -rf "${ROOT_DIR:?}/${name}"
  cp -a "${item}" "${ROOT_DIR}/${name}"
done
shopt -u dotglob

echo "Restoring portal scaffold on top of skeleton..."
shopt -s dotglob
for item in "${BACKUP_DIR}"/*; do
  name="$(basename "${item}")"
  cp -a "${item}" "${ROOT_DIR}/${name}"
done
shopt -u dotglob

rm -rf "${TMP_DIR}" "${BACKUP_DIR}"

echo "Done. Next steps:"
echo "  cp .env.example .env"
echo "  php artisan key:generate"
echo "  composer require laravel/sanctum inertiajs/inertia-laravel darkaonline/l5-swagger"
echo "  npm install"
echo "  php artisan migrate --seed"
echo "  php artisan serve"
