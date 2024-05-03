# Istruzioni per l'uso

Per far partire il progetto:
```
chmod +x setup.sh

./setup.sh
```
In [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/) sarà presente il pannello di phpmyadmin in cui bisogna aggiungere le query presenti in **EcogroupWeb/db/Database.sql** e **EcogroupWeb/db/Seed.sql**.
A questo punto l'app sarà presente e funzionante all'url [https://localhost/www/dist/](https://localhost/www/dist/).


Per fermare il progetto:
```
docker compose down
```

# Ecogroup

Ecogroup è un sito web che aiuta a chiarire il grado di ecosostenibilità delle aziende, tramite dei questionari specializzati.
La piattaforma offre agli utenti aziendali la possibilità di valutare la propria sostenibilità ambientale attraverso un processo semplice e strutturato.

Le aziende creano un profilo, completano un primo questionario ottenendo un  punteggio che riflette il loro livello di ecosostenibilità permettendo di identificare aree di possibile miglioramento con un punteggio che varia da zero a cento.

Gli amministratori hanno accesso a strumenti avanzati per gestire e creare questionari.
Ogni questionario è formato da delle sezioni contenenti domande, le quali formate da testo, categoria e scelte multiple.
I questionari possono essere modificati solo se non ancora compilati, modificando il numero di domande e il loro peso.
Gli amministratori possono vedere inoltre le statistiche dei questionari compilati dalle diverse aziende, questo avviene selezionando un questionario e mettendo a confronto i vari punteggi tra le varie imprese.

1. **Registrazione dell'Azienda:**
    - Gli utenti aziendali devono poter creare un profilo inserendo le informazioni richieste.
    - Deve essere possibile accedere al profilo tramite credenziali (email e password) per futuri accessi.

2. **Questionari:**
    - Le aziende devono essere in grado di svolgere un questionario obbligatorio.
    - Il questionario deve essere composto da domande suddivise in sezioni.
    - Ogni domanda deve avere un testo, appartenere a una categoria, a una sezione e fornire opzioni di risposta.
    - Ogni domanda deve essere marcata con un checkbox che indica se influenza positivamente o negativamente il punteggio finale.
    - Le domande devono essere modificabili dagli amministratori.
      
3. **Punteggio del Questionario:**
    - Dopo aver completato il questionario, l'azienda deve ricevere un punteggio compreso tra 0 e 100, dove 100 rappresenta un alto livello di ecosostenibilità.
      
4. **Gestione degli Amministratori:**
    - Gli amministratori devono poter creare nuovi account amministrativi specificando nickname, email e password.
    - Devono essere in grado di creare e gestire categorie per le domande.
    - Possono visualizzare le categorie esistenti e modificarle.
    - Devono poter creare, modificare e cancellare domande.
    - Possono creare questionari specificando un titolo e suddividendoli in sezioni con domande e relativi pesi.
    - Hanno la possibilità di modificare i questionari prima che siano compilati da almeno un'azienda.
    - Possono visualizzare una lista di tutti i questionari creati.
  
5. **Gestione dei Questionari:**
    - Gli amministratori devono poter visualizzare una lista di tutti i questionari, inclusi quelli compilati e quelli ancora da compilare.
    - Possono modificare il numero di domande e i relativi pesi all'interno dei questionari.
    - Possono visualizzare i punteggi di tutte le aziende che hanno compilato i questionari.
  
# Pagine

Tutte le pagine in cui non viene richiesto l'accesso sono composte da una barra di navigazione che permette all'utente di accedere come amministratore o come utente aziendale ed un footer.

- **Home page** presenta  una sezione composta da paragrafi che spieghino lo scopo del sito e un pulsante che porta alla pagina di sign up.
- **Log in** presenta un form richiedente email e password, se corrette porteranno alla pagina dell'utente oppure alla pagina dell'amministratore, in base alle credenziali inserite.
- **Sign up** presenta un form con tutti i dati richiesti per la registrazione di una nuova azienda, inseriti correttamente tutti i dati si potrà accedere al primo questionario.
- **Pagina utente** presenta una barra di navigazione con le seguenti voci:
	- **Statistiche** (prossima versione) *pensavo ad aree di miglioramento per l'utente in base alle sezioni in cui ha ottenuto punteggi inferiori*.
	- **Questionari compilati** mostra una lista di tutti i questionari compilati e i punteggi.
	- **Nuovo questionario** (prossima versione) *prevista la possibilità di completare nuovi questionari in modo da vedere come l'ecosostenibilità dell'azienda cambia nel tempo*.
- **Pagina amministratore** presenta una barra di navigazione con le seguenti voci:
	- **Statistiche** mostra una lista di tutti i questionari compilati, una volta selezionato un questionario verrà mostrata la lista di tutte le aziende che lo hanno compilato con i relativi punteggi.
	- **Admin** permette l'aggiunta di nuovi amministratori tramite un form.
	- **Domande** permette:
		- l'aggiunta di una nuova domanda.
		- la modifica, partendo da una lista di tutte le domande, selezionando una domanda ancora non presente in un questionario sarà possibile modificarla.
		- l'aggiunta di una nuova categoria per l'organizzazione delle domande.
	- **Questionari** permette:
   		- l'aggiunta di un nuovo questionario.
   		- la modifica di un questionario, partendo da una lista di tutti i questionari non ancora avneti una compilazione da parte dell'azienda.
