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
* **Scrieți un client:** De aceea ne-am adunat aici! 😉
