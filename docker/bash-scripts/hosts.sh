#!/usr/bin/env bash

# declare hosts file location
if is_linux || is_mac; then
  _HOSTS_FILE="/etc/hosts"
else
  _HOSTS_FILE="/c/Windows/System32/drivers/etc/hosts"
fi

# user permissions
if is_linux || is_mac; then
  _USER="sudo"
else
  _USER=""
fi

function remove_hosts_entries() {
  # Mac expects a different paramter format
  if is_mac; then
    _TFILE=`mktemp /tmp/tfile.XXXXX`
  else
    _TFILE=`mktemp --tmpdir tfile.XXXXX`
  fi

  trap "rm -f ${_TFILE}" 0 1 2 3 15

  # copy hosts to temporary folder
  cp "${_HOSTS_FILE}" "${_TFILE}"

  for url in "${_URLS[@]}"; do
    $_USER bash -c "sed --in-place "/"${url}"/d" "${_TFILE}""
  done

  # put temporary content inside of hosts
  $_USER bash -c "cat "${_TFILE}" | $_USER tee "${_HOSTS_FILE}" 1>/dev/null"

  # exit OK
  return 0
}

function add_hosts_entries() {
  for url in "${_URLS[@]}"; do
    $_USER bash -c "echo 0.0.0.0 "${url}" | $_USER tee -a "${_HOSTS_FILE}""
  done
}
