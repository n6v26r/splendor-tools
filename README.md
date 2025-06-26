# Arbitru, viewer și exemplu de agent pentru jocul Splendor

Acest set de unelte vă permite să creați un program (agent) pentru jocul Splendor și să organizați partide contra altor programe.

## Agenții

[Agenții](https://github.com/nerdvana-ro/splendor-tools/tree/main/agent) sînt programe care joacă Splendor. Agenții citesc starea jocului (conținutul mesei și bunurile fiecărui jucător) și răspund printr-o mutare.

Repoul include cîțiva agenți, dintre care [Doofus](https://github.com/nerdvana-ro/splendor-tools/tree/main/agent/doofus) joacă corect (dar modest). Restul agenților (Error, Hang etc.) se comportă anormal și au rostul de a testa buna funcționare a arbitrului.

## Arbitrul

[Arbitrul](https://github.com/nerdvana-ro/splendor-tools/tree/main/arbiter) este unealta care interfațează mai mulți agenți. Arbitrul ține evidența jocului și invocă pe rînd fiecare agent, comunicîndu-i starea curentă. Apoi citește răspunsul agentului și actualizează starea jocului.

Arbitrul poate organiza și turnee cu mai multe partide.

## Viewerul

[Viewerul](https://github.com/nerdvana-ro/splendor-tools/tree/main/viewer) vă permite să vizualizați mutare cu mutare o partidă. El este scris în HTML + Javascript + CSS, deci îl puteți executa în browser.

## Pași de urmat

Vă recomand să încercați uneltele în această ordine:

* **Testați arbitrul**: Faceți instalările și configurările necesare pentru a organiza o partidă între două copii ale agentului Doofus.
  * Dacă rulați Windows, va fi nevoie să instalați WSL. Și acest pas este documentat în secțiunea despre arbitru.
* **Testați viewerul**: Încărcați o partidă salvată în viewer și derulați prin ea.
* **Învățați strategia jocului:** Splendor este un joc cu reguli simple, dar strategie complexă. Vă recomand să jucați cel puțin 5 partide între voi, ca să descoperiți ce merge și ce nu merge. Desigur, puteți citi și opinii de pe Internet.
* **Scrieți un client:** De aceea ne-am adunat aici! 😉

Scopul final al acestei săptămîni este să scrieți un client care să bată cît mai convingător agentul Doofus.

Desigur, vom avea și un turneu final (vom decide formatul miercuri sau joi). Dacă vă clasați onorabil în acel turneu, cu atît mai bine!

## Cîteva cuvinte despre Doofus

Strategia lui Doofus este _greedy_:

* Dacă poate cumpăra o carte, o cumpără. Încearcă mai întîi cărțile de nivel mai mare.
* Dacă poate aduna destule jetoane ca să cumpere o carte la tura viitoare, adună.
* Altfel ia cît de multe jetoane poate, de culori aleatorii.
* Nu rezervă cărți.
* Nu urmărește să ia nobili.

Această strategie nu este deloc eficientă. Doofus termină jocul în 26-28 de runde. Jucătorii umani buni îl termină în 18-20 de runde.

Codul are 600 de linii (.cpp și .h, bine modularizat). Dacă vă ajută la ceva, puteți să vă inspirați din el pentru scheletul programului vostru.
