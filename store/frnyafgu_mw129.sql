-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Mag 22, 2018 alle 20:49
-- Versione del server: 5.7.19
-- Versione PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frnyafgu_mw129`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_messages`
--

DROP TABLE IF EXISTS `admin_messages`;
CREATE TABLE IF NOT EXISTS `admin_messages` (
  `id` bigint(20) NOT NULL,
  `message` varchar(500) NOT NULL,
  `delete` bit(1) NOT NULL DEFAULT b'0',
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `admin_messages_read_by_user`
--

DROP TABLE IF EXISTS `admin_messages_read_by_user`;
CREATE TABLE IF NOT EXISTS `admin_messages_read_by_user` (
  `id` bigint(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `read` bit(1) NOT NULL DEFAULT b'0',
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
CREATE TABLE IF NOT EXISTS `app_settings` (
  `key_name` varchar(20) NOT NULL,
  `value` varchar(20) NOT NULL,
  PRIMARY KEY (`key_name`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `app_settings`
--

INSERT INTO `app_settings` (`key_name`, `value`) VALUES
('last_event_update', '2018-05-22 19:13:26');

-- --------------------------------------------------------

--
-- Struttura della tabella `car_organization`
--

DROP TABLE IF EXISTS `car_organization`;
CREATE TABLE IF NOT EXISTS `car_organization` (
  `id_driver` int(4) NOT NULL,
  `id_passenger` int(4) NOT NULL,
  `id_event` varchar(100) NOT NULL,
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(16) DEFAULT NULL,
  `insert_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_driver`,`id_passenger`,`id_event`),
  KEY `car_organization_events_fk` (`id_event`),
  KEY `car_organization_users_fk_passenger` (`id_passenger`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `car_organization`
--

INSERT INTO `car_organization` (`id_driver`, `id_passenger`, `id_event`, `confirmed`, `confirm_code`, `insert_date`) VALUES
(1, 1, '937369899763334', 0, '', '2018-04-06 14:46:45'),
(1, 4, '937369899763334', 0, NULL, '2018-04-19 21:51:08');

-- --------------------------------------------------------

--
-- Struttura della tabella `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_event` varchar(100) NOT NULL,
  `road` varchar(100) NOT NULL,
  `seats_number` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `drivers_users_fk` (`id_user`),
  KEY `drivers_events_fk` (`id_event`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `drivers`
--

INSERT INTO `drivers` (`id`, `id_user`, `insert_date`, `id_event`, `road`, `seats_number`) VALUES
(1, 38, '2018-04-04 18:00:26', '937369899763334', '[{\"lat\":41.8904018792376,\"lng\":12.511205558349616}]', 2),
(9, 7, '2018-05-02 14:02:13', '1716963521943104', '[{\"lat\":41.90257259777763,\"lng\":12.496957664062506}]', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `meeting_point` varchar(50) NOT NULL DEFAULT 'da definire',
  `departure_coords` varchar(50) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) NOT NULL,
  `id_fb` varchar(100) NOT NULL,
  `meeting_point_name` varchar(50) DEFAULT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `events`
--

INSERT INTO `events` (`id`, `description`, `meeting_point`, `departure_coords`, `event_date`, `insert_date`, `name`, `id_fb`, `meeting_point_name`, `update_date`) VALUES
('1270999596318497', 'L\'idea è di sfruttare il ponte delle festività di S. Pietro e Paolo e farci questi 4 giorni presso il camping Oasi delle Mainarde. Da qui ci sono almeno 100km di sentieri. Il massimo sarebbe arrivare al camping con zaino, sacco e tenda ma non lo pretendo. C\'è anche modo di arrivare al camping in macchina. \n\nPiù in avanti i dettagli. \n\nWww.atropa-trekking.it/ per qualche idea', '41.620401889125,14.131947169094', NULL, '2017-07-08', '2018-03-29 14:18:48', 'Weekend Nelle Mainarde', '1270999596318497', 'Mainarde Molisane', '2018-05-22 20:46:05'),
('1535341239817996', 'La Montanari de Ricotta Co & Sons vi porta alla scoperta delle, ben 7, cascate di Cerveteri, di cui avete qualche scatto originale in questo evento. \nÈ possibile prevedere due giri, uno piu avventuroso e l\'altro diretto alla cascata preposta al meritato bagnetto finale. \nI ritrovi sono:\n- ore 9 a Roma ovest / staz metro cornelia ( https://goo.gl/maps/xCQEEoruDyx )\n- ore 10 Cerveteri cimitero nuovo ( https://goo.gl/maps/fzoGgroY67L2 )\n\nOltre le solite raccomandazioni: acqua da bere, pranzo al sacco, cappello, crema solare ed altro, raccomando fortemente scarpe da trekking impermeabili in quanto ci troveremo varie volte a dover attraversare il fiume. \nIn più, ciabattine e costume.', '42,12.1', NULL, '2017-07-09', '2018-03-29 14:18:48', 'Cascate Di Cerveteri E Bagnetto', '1535341239817996', 'Cerveteri', '2018-05-22 20:46:05'),
('1913242645578221', 'Con le macchine arriveremo al paese di Monteflavio da li si partirà per la fonte campitello. \n10km per un dislivello, dal punto di partenza al punto di arrivo, di 250m.\nPasseremo su alcune selle (zone di valle fra due montagne) a 1.130mt e 1.050mt. (la traccia Nell\'immagine nel post). \nIl giorno seguente, molto presto, toglieremo le tende e, per chi vorrà, saliremo sulla cima del Monte Gennaro per poi riscendere al pratone e tornare alla base Fonte Campitello per il rientro dalla stessa strada, verso Monteflavio .\n\nDa portare:\n- indumenti caldi per la sera\n- Maglie di ricambio per camminare \n- necessario personale per colazione\n- un contenitore con tappo ermetico per riporre la colazione\n- crema solare, cappello, occhiali da sole (il sole d\'estate in montagna è forte)\n- torcia, Lampada frontale (molto utile - due spicci al cinese)\n- carta igienica\n- asciugamano piccolo in microfibra (leggero)\n- prodotti per igiene personale (meglio se naturali)\n- cambio calzini\n- tenda, sacco a pelo\n- medicine personali\n- tazza alluminio personale (3€ al decathlon) \n- mantella per pioggia\n\nAppuntamenti:\n- h 10.30 rebibbia bar antico casello\n- h 11.30 Monteflavio ( zona di parcheggio auto https://goo.gl/maps/mVt7SMNchc72)\n\nL\'idea è quella di pranzare tutti insieme in paese e comprare cibo da cucinare sul fuoco poi la sera. \n\nDocumento google excel per organizzare macchine e tende per il weekend del 15/16 Luglio\nhttps://drive.google.com/open?id=1wp4Y0qwuBt1Y_Oq0uP4sLGQVC6ifLr4MJAId6dZtSDU\n\nVi prego di confermare / disdire per gestire l\'organizzazione auto e tende. \nA meno che non ci si muova in autonomia con la macchina e la tenda.', '42.1,12.8333', NULL, '2017-07-15', '2018-03-29 14:18:48', 'Monte Gennaro E Bivacco Al Pratone', '1913242645578221', 'Monte Flavio', '2018-05-22 20:46:05'),
('1919657561639521', 'Approfittando della notte di San Lorenzo, nota per essere un periodo particolare al passaggio di meteoriti, andremo su una piccola cima calva posta a ca 500mt nella riserva Naturale del Monte Catillo. \n\nSaliremo con la luce del crepuscolo per poi organizzare il pic-nic, distenderci, osservare le stelle e rientrare in tarda serata. \n\nAssaporeremo la bellezza di un percorso, al rientro, in notturna, accompagnati da una bella Luna quasi piena. \n\nÈ una serata aperta davvero a tutti. \nLa strada è poca:\n- circa 3km a piedi\n\nPunti di ritrovo - ca h19:\npunto 1: https://goo.gl/maps/hQpyXZDd5sD2\n(solo per parcheggiare le macchine - gli autisti si sposteranno con al max 2 macchine al punto due dopo aver lasciato gli altri) \npunto 2: https://goo.gl/maps/6CnpXMLcY712\n\nAppuntamento da Roma per andare direzione San Polo de Cavalieri\nh18 zona Settecamini - https://goo.gl/maps/MVZgAs3xNiP2\n\nDa portare:\nCena al sacco\nAcqua\nTorcia elettrica\nTelo (possibilmente di plastica da stendere per isolare dall\'umidità) \nTelo mare \nIndumenti caldi', '42.016666666667,12.833333333333', NULL, '2017-08-05', '2018-03-29 14:18:48', 'Notte Di San Lorenzo', '1919657561639521', 'San Polo dei Cavalieri', '2018-05-22 20:46:05'),
('1510623352292816', 'In preparazione al weekend sul gran sasso e la salita alla cima del corno grande, ci facciamo questa bellissima escursione sul Pizzo Cefalone posto a 2.533mt. \n\nBase di partenza da Campo Imperatore posto a 2.130mt per circa 3 ore di cammino. \n\nCirca 8km solo andata e torneremo per la stessa strada.\n\nOltre le solite raccomandazioni, cibo acqua, scarpe, qui è importante avere indumenti consoni, cappello e felpa perché in quota potrebbe far freddo. \nAggiungerei anche una crema protettiva contro il sole. \n\nQuesto è un percorso di alta montagna, più complesso rispetto i percorsi di valle. Ci vuole il giusto allenamento ed esperienza.', '42.441944,13.587778', NULL, '2017-08-27', '2018-03-29 14:18:48', 'Pizzo Cefalone', '1510623352292816', 'Campo Imperatore', '2018-05-22 20:46:05'),
('1108714415918601', 'Lunghezza: 16Km\nDislivello Complessivo: 1550mt\nDurata: 7h\nGrado di Difficoltà: EE\nPunto di Partenza: Massa d\'Albe (912mt)\nArrivo: 2.488mt\n\nUlteriori dettagli su\nhttp://www.borntotrek.it/index.php?option=com_content&task=view&id=244&Itemid=112\n\nImportante:\n- acqua q. b. (meglio qualcosa in più)\n- giacca a vento\n- felpa/maglione/pile\n- scarpe adatte da trekking\n- bastoncini\n- Pranzo al sacco / alimenti energetici\n\nSi parte dalla piazzetta di Massa D\'Albe (mt.900) dove troviamo un bel\nparcheggio panchine e fontanella. Unica fonte d\'acqua che si incontra durante il percorso è Fonte Canale a\ncirca 2 Km dalla partenza a quota mt.1200. La salita è impegnativa dato il dislivello; unico punto fresco che si incontra durante l\'ascesa per il Velino è il canalino tutto ombreggiato. Percorso \ntecnicamente facile con solo alcuni passaggetti su roccia di I e II\ngrado (è presente una corda da roccia che può aiutare i meno esperti).', '42.15,13.366666666667', NULL, '2017-09-30', '2018-03-29 14:18:48', 'Ascesa Al Monte Velino', '1108714415918601', 'Monte Velino', '2018-05-22 20:46:05'),
('1955114238089152', 'Località di partenza: Fosso Sant\'Angelo, comune di Bassiano (LT),\nstrada per Camporosello, 573 m;\nLocalità di Arrivo: Monte Semprevisa (1.536 m);\nTempo di percorrenza: 3:30 circa per la salita;\nChilometri: 6,79 km sola andata*;\nGrado di difficoltà: EE;\nDescrizione delle difficoltà: Dislivello cospicuo, tratti su pietre,\nalcuni tratti in forte pendenza;\nPeriodo consigliato: Nessuna preclusione particolare, ampi tratti in\nombra soprattutto all\'inizio;\nDislivello in salita: 981m;\nAccesso stradale: strada asfaltata fino al parcheggio\n\nDomenica mattina appuntamento a Subaugusta ore 9\nhttps://goo.gl/maps/4Vr1FvvUUjn\n\nLink al file per organizzare le macchine.\nAttenzione. Selezionate l\'etichetta in basso relativa a questo evento.\nhttps://drive.google.com/open?id=1qHhTCq3AyQRc6DCkTJDNLan4-AnOOqrPsfb89GAp_lA\n\nÈ più comodo editarlo da pc!', '41.55,13.033333333333', NULL, '2017-10-08', '2018-03-29 14:18:48', 'M.te Semprevisa da Bassiano', '1955114238089152', 'Bassiano', '2018-05-22 20:46:05'),
('170745900168786', 'Brevissima e pomeridiana passeggiata dentro l\'antico abitato di Galeria.\n\nLasceremo le macchine nell\'abitato di Santa Maria di Galeria per poi proseguire a piedi sulla strada principale per qualche centinaio di metri prima di immetterci nella proprietà.\n\nAppunto al punto mappa\nVia Monti del Nibbio, 00123 Santa Maria di Galeria RM\n\nhttps://goo.gl/maps/7ZWcXbxLRA72', '42.0333,12.3167', NULL, '2017-10-14', '2018-03-29 14:18:48', 'Galeria Antica', '170745900168786', 'Santa Maria Di Galeria', '2018-05-22 20:46:05'),
('937369899763334', 'Weekend immersi nella natura selvaggia della riserva.\n\nI percorsi sono tanti e vari ma soprattutto panoramici, per poter osservare la bellissima cascata stagionale.\n\nLa struttura ospita fino un massimo di 20 persone.\nE\' autogestita, ma probabilmente la useremo solo per il pernotto e mangeremo e ci faremo il pranzo al sacco in paese.\nLa struttura ha un impianto a GPL per il riscaldamento di tutte le stanze (3).\nLa struttura dispone di materassi con copri materasso, cuscini con federa e piumone e/o coperta.\nLa struttura è raggiungibile solo tramite sentiero (15 minuti a piedi) / solo un auto riceverà in caso, l\'autorizzazione a percorrere la carrereccia che porta al rifugio, per trasporto zaini e altro.\nLa tariffazione cambia in base al numero di occupanti.\nAndiamo dalle:\n- 20€ / pers su una base di 10 occupanti\na\n- 14€ / pers su una base di 20 occupanti\nNon posso ahimè garantire la portata della cascata, che, essendo naturale, varia in base alle condizioni meteorologiche (pioggia e neve).', '41.9436721,12.6199512', NULL, '2018-04-14', '2018-03-29 14:25:47', 'Weekend Nella Riserva Zompo Lo Schioppo', '937369899763334', 'Settecamini', '2018-05-22 20:46:05'),
('555648248137732', 'La data dichiarata è provvisoria da non prendere in considerazione\n\nTempo di percorrenza: 2/3 ore\nChilometri: 2,5\nGrado di difficoltà: T/E (pochi tratti di I°)\nDescrizione delle difficoltà: Nessuna, molto divertente, adatta come primo approccio di arrampicata per i bambini (tratti arrampicata elementare di 1 grado senza alcun pericolo) qualche difficoltà ad attraversare un profondo fosso che taglia in due la valle prima di salire ai Sassoni, la presenza di recinzioni che rendono obbligatorio un lungo aggiramento di essi, comunque agevole.\nSegnaletica: pochi bolli blu (solo nel primo Sassone) \nDislivello in salita: 50 mt\nQuota massima: 237\n\nBellissimo primo approccio all\'arrampicata senza dover necessariamente utilizzare imbarcatura.\n\nE la sera tutti a mangiare a Cerveteri!\n\ningresso: https://goo.gl/maps/Ey98F9Eo75T2', '.', NULL, '2018-09-16', '2018-03-29 14:25:47', 'I Sassoni Di Furbara', '555648248137732', NULL, '2018-05-22 20:46:05'),
('1716963521943104', 'Iniziamo a fare un programma.\n\nL\'idea di massina sono trekking sia il sabato che la domenica.\n\nProgramma di massima:\nSabato arrivo e dopo la sistemazione nel b&b si parte per Punta Telegrafo.\nRietro al b&b\ncena\nDomenica: in mattinata visita alla città di Cosa.\ntarda mattina partenza mini-trekking per una delle calette (speriamo la meno affollata) dell\'Argentario\n\nGiro alla cima più alta dell\'Argentario, punta Telegrafo e il secondo giorno, trekking alla volta delle calette per farci un bello e meritato bagnetto!', '42.45.11.2167', NULL, '2018-06-16', '2018-03-29 14:25:47', 'Weekend Al Monte Argentario E Antica Città Di Cosa', '1716963521943104', 'Orbetello', '2018-05-22 20:46:05'),
('1630886843636811', 'ascesa di ca 1200mt solo per gambe allenate!\n7km solo andata, rientro, pribabilmente dallo stesso sentiero di andata!\nQuota massima: 2.184m slm\nTempo di andata: 4 ore 30 min\n\nL’anello che da Cartore sale al Murolungo per la val di Fua e il lago della duchessa per poi scendere dalla valle di Teve è un superbo itinerario che permette, non senza fatica, di ammirare splendidi panorami in una delle zone più caratteristiche del gruppo. Si tratta di un itinerario classico e molto frequentato, ma piuttosto lungo e discretamente faticoso.', '42.166991866667.13.310842994444', NULL, '2018-06-10', '2018-03-29 14:25:47', 'Monte Murolungo passando dal Lago della Duchessa', '1630886843636811', 'Cartore', '2018-05-22 18:53:58'),
('331784933963955', 'Rifugio Pomito, partenza del sentiero per il Monte Redentore\nhttps://goo.gl/maps/YiXTjWQveBy', '41.30694444.13.63555556', NULL, '2018-09-22', '2018-03-29 14:25:47', 'La Cima Del Redentore E L\' Eremo Di San Michele Arcangelo', '331784933963955', NULL, '2018-05-22 18:53:58'),
('144455659518099', 'Il Fiume Orfento conferisce il nome allo splendido vallone che dalle vette principali del Massiccio della Majella scende fino all´abitato di Caramanico Terme; l´acqua ha scavato, nel corso di milioni di anni, una stretta forra oggi ricoperta da una fitta vegetazione riparia su cui spiccano i salici, le felci ed i muschi.\nA partire dal 1980 all´interno della valle sono stati reintrodotti Cervi e Caprioli, che nel corso degli anni, riproducendosi hanno colonizzato tutto il versante occidentale del Parco.\nLa valle oggi è percorsa da un´articolata rete di sentieri con punti di accesso posti su ambedue i versanti; dall´abitato di Caramanico Terme partono i due sentieri per il Ponte del Vallone e per le Scalelle, mentre a valle del paese si può accedere dal ponte sulla strada statale.\n\n198km da Roma\n\nPernotto nella \"Foresteria del Parco, la Casa del Lupo\"\nAdibita per 25 posti\n\nProssimamente i dettagli dell\'uscita.', '42.15.14.016666666667', NULL, '2018-10-13', '2018-03-29 14:25:47', 'Weekend nella Valle dell\'Orfento', '144455659518099', 'Caramanico Terme', '2018-05-22 20:46:05'),
('1703558093057732', '** Data suscettibile a cambiamenti visto che è abbastanza presto **\n\nDante cita il Cacume nella Divina Commedia!\n\n«Vassi in Sanleo e discendesi in Noli,\nmontasi su Bismantova e ‘n Cacume\ncon esso i piè; ma qui convien ch’om voli; »\n\n*************************\n\nPasseggiata è semplice, adatta anche a non esperti, ed è particolarmente suggestiva in autunno per i colori intensi di cui si vestono gli alberi: castagni, faggi, lecci. Arrivati in cima il panorama è meraviglioso, affaccia sulla Valle del Sacco e fa vedere un orizzonte che abbraccia dai Monti Simbruini alle Mainarde, dal Matese, agli Aurunci. Nelle giornate più limpide lo sguardo può arrivare fino al Monte Circeo e alle isole Pontine.\n\nhttp://www.livefiuggi.com/508/\n\nPartenza: Patrica (Fr) (437 m.)\nMeta:  Monte Cacume (1095 m.)\nCatena Montuosa: Lepini\nDislivello: 691 m.', '41.854023.12.567875', NULL, '2018-10-13', '2018-05-22 20:20:08', 'Monte Cacume da Patrica', '1703558093057732', 'Rome', '2018-05-22 20:46:05'),
('382951612190639', 'Prossimamente i dettagli.\n\nSono per veri allenati! È importante non sopravvalutarsi. È auspicabile considerare le proprie reali possibilità sulla resistenza e tecnica.\n\nIl Dislivello è tanto e ci sono alcuni punti esposti sconsiglistissimi a chi soffre di vertigini anche minime!\n\nI dati sotto riportarti potrebbero variare anche di poco in eccesso o difetto. \n\nDifficoltà: EE\nDislivello complessivo: 1300 m circa\nSviluppo complessivo: 16.5 Km circa', '.', NULL, '2018-07-14', '2018-05-22 20:29:18', 'Monte Gorzano', '382951612190639', NULL, '2018-05-22 20:46:05'),
('372419019938144', 'Quota di Arrivo: 2041mt\nQuota di Partenza: 1143mt\nDislivello: 900mt\n\nPer escursionisti davvero allenati!\n\nDescrizione della salita:\nSi percorre in tutta la sua lunghezza il vasto prato in direzione NE, poi si segue un ramo della radura che si spinge verso N cominciando a salire più decisamente, fino ad entrare nel bosco, seguendo il vecchio sentiero del CAI che si mantiene con qualche svolta sul lato sinistro del fosso della Fragara. Dopo circa 45 minuti dalla partenza si esce dal bosco e si raggiunge il fosso (q. 1450 m) che va attraversato verso destra. Il sentiero ora si inerpica più ripido nel bosco, poi attraversa un´ampia radura verso sinistra (nord-ovest) ed un altro fosso sempre verso sinistra, più avanti piega decisamente a destra (nord-est; q. 1700 m) e risale con alcune svolte l´ultima fascia di bosco, fino ad uscire su terreno più aperto alla base dei vasti pendii sommitali, costellati di massi e radi pini mughi. Da qui il sentiero con molte svolte e sempre piuttosto ripido porta alla sovrastante cresta uscendone sul filo, dopo aver superato la deviazione che porta sulla sinistra al M. del Passeggio. Si segue ora in direzione est la cresta che risale al M. Pratillo (m 2007), che si può scavalcare oppure aggirare tagliandone il versante sud. Si arriva alla sella dove confluisce da nord lo spettacolare vallone di Peschiomacello. Da qui un´ultima breve salita conduce alla vetta (m 2041), croce metallica e Madonnina.\n\n\nDiscesa:\nStessa via di salita oppure per completare un eccezionale anello panoramico reggiungere per cresta M. del Passeggio e discendere da questo (vedi relazione dello stesso autore).\n\n\nNote:\nDalla vetta il panorama è grandioso: nelle giornate più limpide si distinguono chiaramente tutte le maggiori cime dell´Appennino ed il mare Tirreno, con le isole Pontine. E´ interessante osservare (con estrema attenzione, specie in presenza di neve o ghiaccio) l´impressionante parete settentrionale che precipita nella Valle Roveto. In questo versante, dal paese di Roccavivi, si può effettuare una importante salita invernale lungo il vallone di Peschiomacello, con 1500 m di dislivello e difficoltà su neve e ghiaccio.', '.', NULL, '2018-07-07', '2018-05-22 20:29:18', 'Pizzo Deta da Prato di Campoli', '372419019938144', NULL, '2018-05-22 20:46:05'),
('162426867782805', 'Visto che in questo weekend lungo in molti saranno a gareggiare in Francia a Le Mans, apporfitto per tornare nella bellissima Matera e le altrettanto affascinanti Alpi Lucane.\nDopo un primo giorno per aver visitato Matera i suoi sassi e qualche sentieri vicino, e dopo aver mangiato nel locale di un nostro caro amico, ci sposteremo verso Potenza, nella località di Pietrapertosa, dove iniziano i sentieri delle montagne lucane e dove, per chi vorrà c\'è la possibilità di provare l\'ebrezza con un volo aggangiati \"come un salame\" ad una fune d\'acciaio!\nPer tutti gli altri, ci sono tante possibilità carine: dall\'andare attraverso un sentiero al vicino Paese, nonchè stazione di arrivo del \"volo dell\'Angelo\" in totale sicurezza, visto che che è molto frequentato e ben segnato; oppure i bellissimi percorsi attrezzati.\n\nProgramma di massima:\n\nVenerdi 29 Giugno\nArrivo a Matera, sistemazione e giro in città.\nCena\n\nSabato 30 Giugno\nDiscesa nel torrente Gravina e, con l\'utilizzo del ponte sospeso sul torrente visita alle chiese rupestri.\nIn circa 250mt di dislivello riusciremo ad arrivare in due punti panoramici di cui vedere e fotografare i Sassi di Matera.\n\nSentieri facili a mezzacosta sotto la città. L\'unico punto critico per menti sensibili è rappresentato dal ponte.\n\nNel tardo pomeriggio ci si sposta a Potenza.\n\nDomenica 1 Luglio\nMattinata: Trekking e ferrate nel comune di Sasso di Castalda.\nPer chi non c\'era la prima volta c\'è la possibilità di attraversare lo stupendo \"Ponte della Luna\" costo € 15 comprensivo dell’attrezzatura (Biglietteria sita in Piazza del Popolo - Via Roma). NON OCCORRE PRENOTAZIONE. SI PROCEDE IN ORDINE DI ARRIVO NEI GIORNI DI APERTURA AL PUBBLICO\n\nTrekking e ferrate tra i comuni di Pietrapertosa e Castelmezzano.\nEventualmente il \"volo dell\'angelo\" deve essere prenotato e pagato prima online.\n\nSentiero facile e mediamente lungo. Si può fare anche da soli per andare da un comune all\'altro e rientro dallo stesso, per poter visitare entrambi i paese senza per forza doversi lanciare in modalità salsiccia.\n\nCOSTO NOLEGGIO KIT FERRATA (3 ore) € 10,00\nKit da ferrata (Imbrago - Longe e Casco)\nConsigliamo agli utenti di dotarsi di guanti per percorrere agevolmente gli itinerari.', '40.516666666667.16.066666666667', NULL, '2018-06-29', '2018-05-22 20:29:18', 'Il ponte della Luna (per chi non c\'era la prima volta)', '162426867782805', 'Pietrapertosa', '2018-05-22 18:53:58');

-- --------------------------------------------------------

--
-- Struttura della tabella `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `message` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(15) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `parent` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_users_fk_from` (`id_user_from`),
  KEY `messages_users_fk_to` (`id_user_to`),
  KEY `messages_messages_fk` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `messages`
--

INSERT INTO `messages` (`id`, `id_user_from`, `id_user_to`, `message`, `read`, `delete`, `insert_date`, `type`, `subject`, `parent`) VALUES
(3, 3, 38, 'Ciao è tutto ok. Possiamo partire!', 1, 0, '2018-04-06 10:50:21', 'PRIVATE_MESSAGE', 'Organizzazione Macchine', NULL),
(2, 2, 38, 'Ciao è tutto ok. Possiamo partire!', 1, 1, '2018-04-06 10:50:34', 'PRIVATE_MESSAGE', 'Organizzazione Macchine', NULL),
(1, 4, 38, 'Ciao è tutto ok. Possiamo partire!', 1, 0, '2018-04-06 10:50:36', 'PRIVATE_MESSAGE', 'Organizzazione Macchine', NULL),
(4, 7, 38, 'Andiamo insieme?', 1, 0, '2018-04-12 13:32:54', 'PRIVATE_MESSAGE', 'Passeggero per Weekend Nella Riserva Zompo Lo Schioppo', NULL),
(5, 38, 7, 'Ciao, vieni con me? ', 1, 0, '2018-04-12 14:18:01', 'PRIVATE_MESSAGE', 'Autista per Weekend Nella Riserva Zompo Lo Schioppo', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `passengers`
--

DROP TABLE IF EXISTS `passengers`;
CREATE TABLE IF NOT EXISTS `passengers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_event` varchar(100) NOT NULL,
  `meeting_point` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `passengers_users_fk` (`id_user`),
  KEY `passengers_events_fk` (`id_event`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `passengers`
--

INSERT INTO `passengers` (`id`, `id_user`, `insert_date`, `id_event`, `meeting_point`) VALUES
(1, 2, '2018-04-06 14:43:54', '1877345926', ''),
(2, 4, '2018-04-06 14:44:14', '1877345926', ''),
(3, 6, '2018-04-11 00:00:00', '1877345926', ''),
(4, 7, '2018-04-11 00:00:00', '1877345926', ''),
(6, 5, '2018-04-11 00:00:00', '1877345926', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `abitazione` varchar(40) DEFAULT NULL,
  `autonomia` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL,
  `id_player_notifiche` varchar(40) DEFAULT NULL,
  `insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `first_access` tinyint(1) NOT NULL DEFAULT '1',
  `code_confirm` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_un` (`username`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `nome`, `cognome`, `password`, `abitazione`, `autonomia`, `email`, `id_player_notifiche`, `insert_date`, `email_confirm`, `first_access`, `code_confirm`) VALUES
(38, 'danieledagostino', 'Daniele', 'DAgostino', '4df9a801481176889b5efad55f8e680c', '41.85935302938912,12.495139405957048', 1, 'danieledagostino81@gmail.com', NULL, '2018-03-26 18:10:38', 1, 1, 'DymT0cbJSnvJVrq7'),
(2, 'danielerossi', 'Daniele', 'Rossi', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.8579102,12.4115712', 1, 'principelele@gmail.com', NULL, '2018-03-26 18:10:38', 1, 1, NULL),
(4, 'giuseppeverdi', 'Giuseppe', 'Verdi', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.8960571,12.4104182', 1, 'principelele@gmail.com', NULL, '2018-03-26 18:10:38', 1, 1, NULL),
(3, 'pippofranco', 'Pippo', 'Franco', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.9530061,12.4029462', 1, 'principelele@gmail.com', NULL, '2018-03-26 18:10:38', 1, 1, NULL),
(8, 'emanuelebisogni', 'Emanuele', 'Bisogni', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.9145901,12.5817212', 1, 'principelele@gmail.com', NULL, '2018-04-11 00:00:00', 1, 1, NULL),
(7, 'simonacianci', 'Simona', 'Cianci', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.8739852,12.5603762', 1, 'principelele@gmail.com', NULL, '2018-04-11 00:00:00', 1, 1, NULL),
(6, 'salvatricebald', 'Salvatrice', 'Bald', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.8126441,12.5172562', 1, 'principelele@gmail.com', NULL, '2018-04-11 00:00:00', 1, 1, NULL),
(5, 'davidecestra', 'Davide', 'Cestra', 'f88e66d82bd7e98a2aa1fba446f2dd0f', '41.8111281,12.4493772', 1, 'principelele@gmail.com', NULL, '2018-04-11 00:00:00', 1, 1, NULL),
(40, 'pincopallino2', 'da', 'dasdsa', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 'principelele@gmail.com', NULL, '2018-05-19 16:08:37', 0, 1, 'psngrkkdvmZqOra2'),
(41, 'danieledagostino2', 'Daniele', 'D\'Agostino', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 'principelele@gmail.com', NULL, '2018-05-19 16:11:03', 0, 1, 'hS17MIpCHtaoWHNz'),
(42, 'danieledagostino3', 'Daniele', 'D\'Agostino', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 'principelele@gmail.com', NULL, '2018-05-19 16:15:59', 0, 1, 'wAcHMCpB1eAiRy1S'),
(43, 'danieledagostino4', 'Daniele', 'D\'Agostino', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0, 'principelele@gmail.com', NULL, '2018-05-19 16:19:33', 0, 1, '8ukvtX4y6hqsjcwj');

-- --------------------------------------------------------

--
-- Struttura della tabella `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id_user` int(11) NOT NULL,
  `push_message` varchar(2) NOT NULL DEFAULT 'si',
  `email_message` varchar(2) NOT NULL DEFAULT 'si',
  `email_car_summary` varchar(2) NOT NULL DEFAULT 'si',
  `email_event_summary` varchar(2) DEFAULT 'si',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user_settings`
--

INSERT INTO `user_settings` (`id_user`, `push_message`, `email_message`, `email_car_summary`, `email_event_summary`) VALUES
(38, 'no', 'no', 'si', 'si'),
(40, 'si', 'si', 'si', 'si'),
(41, 'si', 'si', 'si', 'si'),
(42, 'si', 'si', 'si', 'si'),
(43, 'si', 'si', 'si', 'si');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
