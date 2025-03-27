#!/bin/bash

# Script zum Hinzufügen eines 'ofcp-api-gateway.tecsafe-local.de'-Eintrags in /etc/hosts
# Dieses Script wird beim Post-Start-Hook von DDEV ausgeführt

# Da wir im Host-System arbeiten, benötigen wir sudo
#if [ "$(id -u)" -ne 0 ]; then
#    # Hier verwenden wir sudo, da der Hook im Kontext des Host-Benutzers ausgeführt wird
#    echo "Benötige sudo-Rechte zum Bearbeiten von /etc/hosts..."
#
#    # Das Script neu mit sudo ausführen
#    exec sudo "$0" "$@"
#    exit $?
#fi

# Die IP-Adresse für host.docker.internal aus der /etc/hosts extrahieren
DOCKER_IP=$(grep "host.docker.internal" /etc/hosts | awk '{print $1}')

if [ -z "$DOCKER_IP" ]; then
    echo "Die IP-Adresse für host.docker.internal wurde nicht gefunden."
    exit 1
fi

echo "IP-Adresse für host.docker.internal gefunden: $DOCKER_IP"

# Überprüfen, ob foobar bereits in /etc/hosts existiert
if grep -q "ofcp-api-gateway.tecsafe-local.de" /etc/hosts; then
    # Bestehenden Eintrag aktualisieren
    echo "Aktualisiere bestehenden ofcp-api-gateway.tecsafe-local.de-Eintrag..."
    sed -i "/ofcp-api-gateway.tecsafe-local.de/d" /etc/hosts
    echo "$DOCKER_IP ofcp-api-gateway.tecsafe-local.de" >> /etc/hosts
else
    # Neuen Eintrag für foobar hinzufügen
    echo "Füge neuen ofcp-api-gateway.tecsafe-local.de-Eintrag hinzu..."
    echo "$DOCKER_IP ofcp-api-gateway.tecsafe-local.de" >> /etc/hosts
fi

# Zur Bestätigung den neuen Eintrag anzeigen
echo "Aktueller Eintrag in /etc/hosts:"
grep "ofcp-api-gateway.tecsafe-local.de" /etc/hosts