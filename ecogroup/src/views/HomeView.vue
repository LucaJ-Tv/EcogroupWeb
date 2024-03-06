<template>
  <div class="grid grid-cols-1 gap-3 px-16 py-3 text-center lg:grid-cols-3">
        <div class="lg:col-span-3 col-span-1 bg-site-primary bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>L'obiettivo di questa Checklist è valutare l'adozione da parte dell'azienda di principi Green, Lean, Agile e Resilient (LARG) e le potenzialità aziendali di far parte di una ISN (Industrial Symbiosis Network). Le reti di simbiosi industriale (ISN) stanno emergendo come opzioni sostenibili per consentire la cooperazione tra più catene di approvvigionamento e per ottimizzare l'uso di risorse materiali ed energetiche all'interno di un'area geografica. La Checklist proposta analizza diverse aree tematiche (Green, Lean, Agile, Resilient, Maturità aziendale, Risorse Input-Output) tramite domande in forma qualitativa e a risposta guidata. Il risultato della Checklist è un punteggio che dà una visione d'insieme dell'azienda riguardo questi principi, considerandoli sia singolarmente che adeguatamente integrati. 
          I dati vengono raccolti per scopo di ricerca e saranno trattati mantenendo la riservatezza di essi tramite analisi aggregate.</p>
        </div>
        <div class="bg-site-primary bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600  p-4 rounded-lg">
          <p>Dopo aver cliccato il tasto sulla destra "INIZIO CHECKLIST", comparirà un nuovo foglio di lavoro chiamato "DATI AZIENDA", dove vi sarà richiesto di compilare i dati anagrafici della vostra azienda.</p>
        </div>
        <div class="bg-site-primary  bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>Compilate ogni campo richiesto del foglio "DATI AZIENDA".</p>
        </div>
        <div class="bg-site-primary  bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>Una volta effettuata la compilazione, cliccate sul bottone "INVIA DATI AZIENDA". ATTENZIONE: non è possibile modificare i dati una volta cliccato il bottone. Comparirà un nuovo foglio denominato "CHECKLIST" che sarà suddiviso nelle cinque macro-aree sopra descritte. Per ogni domanda c'è un menù a tendina che suggerisce le risposte possibili.</p>
        </div>
        <div class="bg-site-primary  bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>Compilate TUTTI i campi per poter procedere all'invio dei dati e all'elaborazione del risultato. Cliccare sul bottone "CALCOLA PUNTEGGIO" per procedere. Dopo il click compariranno contemporaneamente: (1) un nuovo foglio chiamato "REPORT FINALE", (2) una e-mail indirizzata agli organizzatori per poter ricevere i vostri risultati ed elaborarli.</p>
        </div>
        <div class="bg-site-primary  bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>Il foglio denominato "REPORT FINALE" è strutturato nelle stesse macro-aree della Checklist, dettagliandone le metriche valutate. Per ognuna delle aree comparirà un punteggio parziale, mentre in fondo saranno presenti i punteggi totali (LARG e Simbiosi Industriale) della checklist.</p>
        </div>
        <div class="bg-site-primary  bg-opacity-70 hover:bg-opacity-80 backdrop-blur-md drop-shadow-lg border-green-600 p-4 rounded-lg">
          <p>I punteggi ottenuti sono calcolati sulla base delle risposte fornite nella checklist e di pesi ad esse associate stabiliti in precedenza. I punteggi possono variare da 0 a 100, dove 0 sta per una scarsa propensione ad adottare pratiche LARG e di simbiosi industriale, mentre 100 sta per una estrema propensione. ATTENZIONE: i punteggi danno un'indicazione su potenziali aree di miglioramento e si devono considerare come uno spunto per azioni future.</p>
        </div>
        <router-link to="/sign-in" class="lg:col-start-2 bg-green-600 bg-opacity-60 backdrop-blur-md drop-shadow-lg p-4 rounded-lg hover:bg-green-800 transition ease-out hover:delay-100 ">INIZIO</router-link>
        
      </div>
</template>

<script>
  export default{
  }
</script>
