#!/usr/bin/env bash
set -euo pipefail

if [[ "${EUID}" -ne 0 ]]; then
  echo "Please run as root: sudo bash setup.sh"
  exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

apt-get update
apt-get install -y ansible

ANSIBLE_CONFIG="${SCRIPT_DIR}/provision/ansible.cfg" \
  ansible-playbook \
  -i "${SCRIPT_DIR}/provision/inventory/hosts.ini" \
  "${SCRIPT_DIR}/provision/playbooks/site.yml"
