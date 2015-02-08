CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE TABLE IF NOT EXISTS benutzer (
    id SERIAL PRIMARY KEY ,
    password text NOT NULL,
    email text NOT NULL UNIQUE,
    anrede text default '',
    vorname text default '',
    nachname text default '',
    strasse text default '',
    hausnummer text default '',
    plz text default '',
    ort text default '',
    logo text default '',
    logo_width int NOT NULL default '0',
    logo_height int NOT NULL default '0',
    design text NOT NULL default 'classic',
    use_bzz text NOT NULL default 'bzz',
    name text NOT NULL default '',
    type text NOT NULL default 'private',
    fenster int NOT NULL default '0',
    falz int NOT NULL default '1',
    firmenname text NOT NULL default '',
    telefon text NOT NULL default '',
    fax text NOT NULL default '',
    internet text NOT NULL default '',
    ga1 text NOT NULL,
    ga2 text NOT NULL,
    ga3 text NOT NULL,
    isadmin int NOT NULL
);

CREATE TABLE IF NOT EXISTS briefe (
  id SERIAL PRIMARY KEY,
  benutzer int ,
  betreff text NOT NULL default '',
  text text NOT NULL,
  letter_type text NOT NULL default 'business',
  design text NOT NULL default 'classic',
  showFensterLine int NOT NULL default '0',
  showFalzLine int NOT NULL default '1',
  header text NOT NULL default '',
  absender_firmenname text default '',
  absender_anrede text default '',
  absender_vorname text default '',
  absender_nachname text default '',
  absender_strasse text default '',
  absender_hausnummer text default '',
  absender_plz text default '',
  absender_ort text default '',
  bzz_use text default '',
  bzz_ihrzeichen text default '',
  bzz_unserzeichen text default '',
  bzz_name text default '',
  bzz_telefon text default '',
  bzz_fax text default '',
  bzz_email text default '',
  bzz_internet text default '',
  bzz_datum text default '',
  ga1 text,
  ga2 text,
  ga3 text,
  empfaenger_firmenname text default '',
  empfaenger_anrede text default '',
  empfaenger_vorname text default '',
  empfaenger_nachname text default '',
  empfaenger_strasse text default '',
  empfaenger_hausnummer text default '',
  empfaenger_plz text default '',
  empfaenger_ort text default '',
  empfaenger_show_normal int NOT NULL default '1',
  empfaenger_full text NOT NULL,
  ortdatum text default NULL,
  titel text default NULL,
  beschreibung text,
  usepublic int NOT NULL,
  ispublic int NOT NULL default '0',
  uid text NOT NULL,
  showpublic int NOT NULL default '0'
);

CREATE TABLE IF NOT EXISTS empfaenger (
  id SERIAL PRIMARY KEY,
  benutzer int NOT NULL,
  firmenname text default NULL,
  anrede text default NULL,
  vorname text default NULL,
  nachname text default NULL,
  strasse text default NULL,
  hausnummer text default NULL,
  plz text default NULL,
  ort text default NULL,
  show_normal int NOT NULL default '1',
  "full" text NOT NULL
);

CREATE TABLE IF NOT EXISTS outgoing_letters (
  id SERIAL PRIMARY KEY,
  session text default NULL,
  successfull int default '0',
  method text default 'lvin',
  letter_hash text default NULL,
  created timestamp NULL default NOW(),
  content bytea,
  price int default NULL
);

CREATE TABLE IF NOT EXISTS paypal_ipn_incoming (
  id SERIAL PRIMARY KEY,
  txn text NOT NULL default '',
  email text NOT NULL default '',
  amount int NOT NULL default '0',
  successfull int NOT NULL default '0',
  outgoing_letter int NOT NULL default '0',
  post text,
  response text
);

CREATE TABLE IF NOT EXISTS static (
  filename text PRIMARY KEY,
  created timestamp NOT NULL default NOW(),
  lifetime int default NULL,
  size int NOT NULL,
  data bytea NOT NULL
);

CREATE TABLE IF NOT EXISTS textbausteine (
  id SERIAL PRIMARY KEY,
  text text NOT NULL,
  schlagwoerter text NOT NULL
);

CREATE TABLE IF NOT EXISTS vorlagen (
  id SERIAL PRIMARY KEY,
  betreff text NOT NULL,
  text text NOT NULL,
  titel text NOT NULL,
  kategorie text NOT NULL
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO rapidletter;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO rapidletter;

INSERT INTO textbausteine VALUES (1,'Für ein persönliches Gespräch stehen wir Ihnen gern zur Verfügung.\r\nRufen Sie uns bitte an und vereinbaren einen Termin mit uns.','Gespräch Persönlich Abschluss Termin'),(2,'Mit freundlichen Grüßen','Schluss Grüße Ende'),(3,'Sehr geehrte Damen und Herren,\r\n\r\n','Beginn Anfang Begrüßung'),(4,'Für die Ihnen entstandenen Unannehmlichkeiten möchten wird uns entschuldigen.','Entschuldigung Kundenservice Unannehmlichkeiten Fehler'),(5,'Bitte senden Sie mir Unterlagen über alle passenden Produkte mit genauen Beschreibungen und Preisangaben. ','Preis Anfrage Preisanfrage'),(6,'Wenn Sie Fragen dazu haben, rufen Sie mich bitte an. Unter der Telefonnummer 01234/56789 stehe ich Ihnen gerne zur Verfügung. ','Nachfrage Telefon Fragen'),(7,'Danke für Ihre Bewerbung und Ihr Interesse, unser Team zu verstärken. Wir haben uns darüber sehr gefreut. \r\n\r\nWir haben sehr viele interessante Bewerbungen erhalten, die Entscheidung ist uns nicht leicht gefallen. Wir haben uns dann doch für einen anderen Bewerber entschieden, der bereits Erfahrung im Verkauf hat. ','Bewerbung Absage'),(8,'Es tut mir leid, Ihnen keine anderen Neuigkeiten senden zu können. ','schlechte Nachricht'),(9,'Ich freue mich schon darauf, Sie in einem persönlichen Gespräch kennenzulernen. Sie erreichen mich unter der Telefonnummer 01234/56789 oder per E-Mail unter der Adresse max.mustermann@doamin.de . ','Bewerbung Kontakt'),(10,'Wir haben sehr viele interessante Bewerbungen erhalten, die Entscheidung fällt uns nicht leicht. Deshalb bitten wir Sie noch um ein bisschen Geduld. Wir melden uns in den nächsten zwei Wochen bei Ihnen. ','Bewerbung Reaktion Aufschub'),(11,'Ich danke Ihnen für die gute Zusammenarbeit und wünsche Ihnen weiterhin viel Erfolg für das Unternehmen. ','Abschluss Geschäftlich'),(12,'Mit diesem Schreiben kündige ich mein Dienstverhältnis mit der Firma [Name] per [Datum] unter Einhaltung der [ein, zwei, drei]monatigen Kündigungsfrist. ','Kündigung Frist Anstellung');
alter sequence textbausteine_id_seq restart with 13;
INSERT INTO vorlagen VALUES (1,'Mahnung - Überziehung Konto-Nr. 12345678','Sehr geehrter Herr Mustermann, \r\n\r\nSie haben mit uns eine Kreditlinie von [Betrag] EUR vereinbart. Der Schuldsaldo beträgt [Betrag] EUR, so dass der vereinbarte Kreditrahmen um [Betrag] EUR überschritten ist. Bitte führen Sie den Saldo bis zum [Datum] in den vereinbarten Kreditrahmen zurück.\r\n\r\nSollte Ihnen die Abdeckung des Schuldsaldos in einer Summe nicht möglich sein, bitten wir Sie, uns entsprechende Tilgungsvorschläge zu unterbreiten.\r\n\r\nBitte beachten Sie, dass Überziehungen unbedingt rechtzeitig vorher mit Ihrem Kundenberater abgestimmt werden. Sie vermeiden damit, dass es im laufenden Zahlungsverkehr auf Ihrem Girokonto zu Zahlungsstörungen kommen kann.\r\n\r\nFür ein persönliches Gespräch stehen wir Ihnen gern zur Verfügung.\r\nRufen Sie uns bitte an und vereinbaren Sie einen Termin mit uns.\r\n\r\nMit freundlichen Grüßen','Mahnung bei Kontoüberziehung','Geschäftlich'),(2,'Strittige Forderung - Serviceleistung und Minderjährigkeit','Sehr geehrte Damen und Herren,\r\n\r\nich beziehe mich auf Ihr Schreiben vom [Datum], in dem Sie einen Betrag von [Betrag] Euro für eine Serviceleistung verlangen.\r\n\r\nDer angeblich bestehende Vertrag wurde von meinem minderjährigen Sohn/meiner minderjährigen Tochter abgeschlossen. Ich habe aber nicht in den Abschluss des Ihrer Meinung nach bestehenden Vertrages eingewilligt und würde/werde ihn auch nicht nachträglich genehmigen.\r\n\r\nNach meiner Überzeugung wurde auch unabhängig davon kein rechtsgültiger Vertrag abgeschlossen. Dennoch widerrufe ich zusätzlich vorsorglich den Ihrer Meinung nach bestehenden Vertrag gemäß den Bestimmungen des Fernabsatzrechtes und fechte ihn auch hilfsweise wegen arglistiger Täuschung an. Auch erkläre ich vorsorglich die Anfechtung wegen eines Irrtums über den Inhalt der abgegebenen Willenserklärungen.\r\n\r\nIch gehe davon aus, dass die Angelegenheit erledigt ist und bitte Sie um eine entsprechende Bestätigung.\r\n\r\nMit freundlichen Grüßen\r\n','Internetabzocke (minderjährig)','Privat'),(3,'Rechnung vom [Datum]','Sehr geehrte Damen und Herren, \r\n\r\nZu Ihrer Rechnung vom [Datum] stelle ich fest: \r\n\r\nSollte ich mich tatsächlich am [Datum] auf [Internetadresse] angemeldet haben, war ich mir der damit verbundenen Kosten nicht bewusst. Hierüber wurde ich erst durch Ihr Schreiben aufgeklärt. Aufgrund der unzureichenden Preisinformation auf Ihrer Seite fehlt es daher bereits an einem wirksamen Vertragsschluss zu den von Ihnen behaupteten Konditionen. \r\n\r\nHilfsweise erkläre ich die Anfechtung einer etwaigen vertragsbezogenen Willenserklärung, weil von mir lediglich eine kostenlose Nutzung gewollt war und keine kostenpflichtige. \r\n\r\nSchließlich mache ich hilfsweise auch von meinem Widerrufsrecht aus §§ 312d, 355 ff. BGB Gebrauch. Da eine den gesetzlichen Vorgaben entsprechende Widerrufsbelehrung in Textform nicht erteilt worden ist, ist der Widerruf auch nicht durch Fristablauf ausgeschlossen. \r\n\r\nAus den genannten Gründen werde ich keinerlei Zahlung leisten. \r\n\r\nVon weiteren Mahnungen bitte ich abzusehen. \r\n\r\nMit freundlichen Grüßen ','Internetabzocke','Privat'),(4,'Kündigung der Kfz-Haftpflichtversicherung (Vers.Nr. [Versicherungsnummer]) für Pkw [Kennzeichen]','Sehr geehrte Damen und Herren,\r\n\r\nhiermit kündige ich zum [TT.MM.JJJ] die Haftpflichtvericherung für das Fahrzeug mit dem amtlichen Kennzeichen [AA-BB 1234].\r\n\r\nAm [TT.MM.JJJ] habe ich mein Fahrzeug an [Frau/Herrn Max Mustermann, Musterstrasse 1, 01234 Musterstadt] verkauft.\r\n\r\nSollte aufgrund bereits gezahlter Beträge ein Restbetrag bestehen, bitte ich um eine Rücküberweisung auf folgendes Konto:\r\n\r\nKontonummer: [xxx xxx xxx]\r\nBankleitzahl:[xxx xxx xxx]\r\nGeldinstitut:[xxx xxx xxx]\r\n\r\nMit freundlichen Grüßen','Kündigung der KFZ Versicherung','Privat'),(6,'Ihre Anfrage vom [TT.MM.JJJ]','Sehr [geehrte Frau/geehrter Herr Max Mustermann],\r\n\r\nvielen Dank für Ihr Interesse an unserem Unternehmen. Wir freuen uns, dass Sie mit Ihrem Arbeitsprofil auf uns zugekommen sind, müssen jedoch derzeit davon absehen, da vorerst keine Neubesetzung oder Erweiterung geplant ist.\r\n\r\nWenn es Ihnen recht ist, würden wir Ihre Kontaktdaten jedoch vorerst in unseren Bewerber-Pool aufnehmen, um Sie bei kurzfristigem Bedarf zu kontaktieren.\r\n\r\nBeste Grüße','Bewerbungsabsage Initiativbewerbung','Geschäftlich'),(7,'Auftragsbestätigung zu Ihrer Bestellung vom [Datum]','Sehr geehrter [Herr Mustermann],\r\n\r\nwir danken Ihnen für Ihre Bestellung und bestätigen Ihnen hiermit die Lieferung [des Blumentopfes Marke \"Wiesengrün\"] zum Preis von € [Betrag].- zzgl. MwSt. zum [01. Januar 2011] an die von Ihnen angegebene Adresse*\r\nDie Rechnung erfolgt mit gesonderter Post. Bei Zahlung des Kaufpreises innerhalb von [10] Tagen nach Lieferung erhalten Sie [3%] Skonto. \r\nAnsonsten zahlen Sie bitte den Rechnungsbetrag innerhalb von 30 Tagen.\r\n\r\nDie detaillierten Konditionen entnehmen Sie bitte unseren allgemeinen Verkaufs- und Lieferbedingungen [auf der Rückseite dieser Auftragsbestätigung].\r\n \r\nBei Rückfragen steht Ihnen jederzeit ein Mitarbeiter via e-Mail oder Telefon zur Verfügung. Bitte halten Sie dazu Ihre Angebots-Nr. bereit.\r\nFür die zuverlässige Ausführung Ihres Auftrags werden wir stets Sorge tragen.\r\n\r\nMit freundlichen Grüßen \r\n','Auftragsbestätigung','Geschäftlich'),(8,'Anfrage wegen [Fahrrad Anhänger]','Sehr geehrte Damen und Herren,\r\n\r\nfür unseren Betrieb benötigen wir einen Fahrradanhänger mit mindestens 30 KG Nutzlast. \r\n\r\nBitte bieten Sie uns dazu mehrere [Fahrradanhänger] inklusive eines Preis-/Leistungsvergleichs an.\r\n\r\nDes Weiteren wären wir für die Zusendung eines Prospektes und die Angabe der uns nächstgelegenen Vertragspartner dankbar.\r\n\r\nVielen Dank für die schnelle Bearbeitung unserer Anfrage!\r\n\r\nMit freundlichen Grüßen\r\n','Produktanfrage','Geschäftlich'),(9,'Anfrage [einer Marmorplatte]','Sehr geehrte Damen und Herren,\r\n\r\nfür [unsere Küche] benötigen wir [eine helle Marmorplatte]. \r\nBitte bieten Sie uns dazu mehrere Vorschläge inklusive eines Preis-/Leistungsvergleichs an.\r\n\r\nDes Weiteren wären wir für die Zusendung eines Prospektes dankbar.\r\n\r\nVielen Dank für die schnelle Bearbeitung unserer Anfrage!\r\n\r\nMit freundlichen Grüßen\r\n','Produktanfrage','Privat'),(10,'Lieferverzögerung Ihres Produktes [Art.Nr, Bezeichnung]','Sehr geehrter [Herr Nachname],\r\n\r\nobwohl wir nichts unversucht ließen, um den Lieferverzug wieder aufzuholen, [der durch einen Unfall bei unserem Spediteur entstanden ist], konnten wir Ihre Bestellung nicht bis zum vereinbarten Termin [Datum] liefern. \r\n\r\nDas tut uns ganz außerordentlich leid! Wir möchten Sie dennoch nicht als Kunden verlieren. Deshalb machen wir Ihnen nach Rücksprache mit unserer Firmenleitung folgendes Angebot: Sie erhalten [eine Gutschrift in Höhe von [Betrag € Anhänger] von uns auf Ihr Konto angerechnet.\r\n\r\nDer neu errechnete Liefertermin ist nun der [Datum]. \r\n\r\nWir würden uns sehr freuen, wenn Sie unser Angebot annehmen würden. Für Fragen \r\nstehen wir Ihnen natürlich gerne zur Verfügung. \r\n\r\nBeste Grüße\r\n','Kulanz','Geschäftlich'),(11,'Kündigung der Mitgliedschaft [Vertragsnummer]','Sehr geehrte Damen und Herren, \r\n\r\nhiermit kündige ich meine Mitgliedschaft fristgerecht zum nächstmöglichen Zeitpunkt. \r\nBitte senden Sie mir eine schriftliche Bestätigung der Kündigung unter Angabe des Beendigungszeitpunktes zu.\r\n\r\n \r\nMit freundlichen Grüßen','Kündigung einer Mitgliedschaft','Privat'),(12,'Versicherungsnummer 12345/6789','Sehr geehrte Damen und Herren,\r\n\r\nam [Datum] ließ ich mich von Facharzt Dr. Max Mustermann behandeln. Heute schicke ich Ihnen die Honorarnote dieser Behandlung.\r\n\r\n\r\nBitte überweisen Sie den Rechnungsbetrag auf folgendes Konto:\r\n\r\nInhaber: [Max Mustermann]\r\nKontonummer: [12345]\r\nBLZ: [100000]\r\nInstitut: [Musterbank AG]\r\n\r\n\r\nHerzlichen Dank!\r\n\r\n\r\n\r\n\r\nFreundliche Grüße','Rückerstattung, Versicherung','Privat'),(17,'Kündigung [Kontoart]','Sehr geehrte Damen und Herren,\r\n\r\nhiermit kündige ich mein Konto mit der Kontonummer [123456] zum [Datum/ nächst möglicher Zeitpunkt].\r\nBitte schicken Sie mir eine Bestätigung der Kündigung an folgende Adresse [Absenderadresse] zu.\r\n[Bitte überweisen Sie das restliche Geld auf folgendes Konto: Kontonummer 1234567, BLZ 12345678, Kontoinhaber Absender.]\r\n\r\nMit freundlichen Grüßen','Kontokündigung','Privat'),(18,'Kündigung Bahncard','Sehr geehrte Damen und Herren,\r\n\r\nhiermit kündige ich meine Bahncard [Nr 123456] zum [Datum/ nächst möglicher Zeitpunkt].\r\nBitte schicken Sie mir eine Bestätigung der Kündigung an folgende Adresse [Absenderadresse].\r\n\r\nMit freundlichen Grüßen','Kündigung Bahncard','Privat'),(19,'Beantragung eines neuen Mitgliedsausweises','Sehr geehrte Damen und Herren,\r\n\r\nhiermit beantrage ich einen neuen Mitgliedsausweis, da ich meinen bisherigen Ausweis [Ausweisnummer] [verlegt habe/verloren habe/mir gestohlen wurde].\r\nBitte senden Sie den Ausweis an folgende Adresse: [Absenderadresse].\r\n\r\nMit freundlichen Grüßen\r\n\r\n\r\n','Beantragung Mitgliedsausweis','Privat');
alter sequence vorlagen_id_seq restart with 20;