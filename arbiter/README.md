Arbitrul este unealta care interfațează mai mulți agenți. Arbitrul ține evidența jocului și invocă pe rînd fiecare agent, comunicîndu-i starea curentă. Apoi citește răspunsul agentului și actualizează starea jocului.

## Pas specific pentru Windows: instalează WSL

Arbitrul este scris în PHP. Există mai multe moduri de a rula PHP în Windows. Instrucțiunile următoare documentează prima metodă.

1. Prin [WSL]([url](https://learn.microsoft.com/en-us/windows/wsl/)) (Windows Subsystem for Linux).
2. Printr-o mașină virtuală.
3. Direct cu PHP pentru Windows (nu am încercat).

Instalează o distribuție de GNU/Linux (implicit Ubuntu). Din terminal, listează distribuțiile disponibilie:

```bash
wsl --list --online
```

Apoi instalează-o pe cea dorită, de exemplu

```bash
wsl --install Ubuntu-25.04
```

Va cere reboot, apoi va finaliza instalarea. Alege-ți un nume de utilizator și o parolă. Apoi te vei găsi într-un prompt de Linux.

Adu la zi sistemul și instalați PHP. Pentru Ubuntu, comenzile necesare sînt:

```bash
sudo apt update
sudo apt upgrade
sudo apt install php
```

Testează că PHP merge:

```bash
php --version
```

Poti vedea sistemul de fișiere Windows din Linux:

```bash
ls /mnt/c/
```

De asemenea, poți vedea sistemul de fișiere Linux din Windows. Din File Explorer, navighează la Linux > Ubuntu-25.04 > /home/\<username\>/ etc.

## Clonează repo-ul și testează arbitrul

Navighează într-un director bine ales. 🙂 Apoi:

```bash
git clone https://github.com/nerdvana-ro/splendor-tools
cd splendor-tools
```

Pe viitor, avînd în vedere că eu continui să lucrez la cod, poți obține ultima versiune a codului executînd, din interiorul directorului:

```bash
git pull
```

Rulează arbitrul, fără argumente, ca să te asiguri că merge:

```bash
php arbiter/arbiter.php
```

Dacă merge, vei vedea un mesaj cu instrucțiuni de apelare.

## Compilează clientul Doofus

Pentru aceasta, vei avea nevoie de compilatorul de C++ (`g++`) și de utilitarele `cmake` și `make`. Vom descoperi împreună ce pachete trebuie instalate. Pentru Ubuntu, cred că sînt acestea:

```bash
sudo apt install build-essential cmake
```

Acum poți compila agentul:

```bash
cd agent/doofus/build
cmake ../
make
cd ../../../
```

## Rulează o partidă între două copii ale agentului

```bash
php arbiter/arbiter.php --binary agent/doofus/build/doofus --name doofus1 --binary agent/doofus/build/doofus --name doofus2
```

Ar trebui să verse ecrane întregi de informații, cu starea jocului după fiecare mutare (grafică text).

Creează un director pentru partidele salvate, de exemplu:

```bash
mkdir ~/Desktop/games
```

Rulează o nouă partidă și spune-i să salveze partida:

```bash
php arbiter/arbiter.php --binary agent/doofus/build/doofus --name doofus1 --binary agent/doofus/build/doofus --name doofus2 --save ~/Desktop/games/
```

Acum în `~/Desktop/games` vei găsi fișierul `game-001.json`.

## Opțiuni de configurare pentru arbitru

Arbitrul mai admite opțiunile `--games <număr>` pentru a organiza mai mult de o partidă și `--seed <număr>` pentru a genera în mod repetabil același pachet de cărți.

În plus, poți modifica valorile constantelor din `Config.php`. Fiecare constantă este documentată. De exemplu, poți reduce nivelul de zgomot reducînd valoarea lui `LOG_LEVEL`.
