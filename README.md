# Vad finns det för krav du måste anpassa dig efter i de olika API:erna?
Det jag har hittat i API:ernas dokumentation är att Sveriges Radio uppmuntrar till att vara snälla mot API:et och begränsa anropen.

# Hur och hur länga cachar du ditt data för att slippa anropa API:erna i onödan?
Trafikinformationen lagras i 5 minuter på servern, vilken enkelt går att ställa in. Jag anser att detta är en lämplig tidsperiod då det är viktigt att ha så färsk information som möjligt men att samtidigt hålla nere serveranropen. Rent tekniskt sparas informationen med en tidsstämpel som kollas vid varje anrop, har gränsen i inställningarna passerats görs ett anrop mot API:et och en ny fil skapas.

Samma tidsbegränsning skickas även till klienten att det är okej att cachea datat när första anropen mot applikationen sker.

# Vad finns det för risker kring säkerhet och stabilitet i din applikation?
Det finns alltid risk för t.ex. en DDOS-attack, men om vi bortser från det så finns det inga resurser som kräver vare sig autentisiering eller auktorisering. 

Således sätts heller inte en session-cookie då det inte finns någon anledning att spara någonting i sessionen. 

Applikationen är beroende av en extern CDN som tillhandahåller kartverktyget. Skulle denna sluta fungera är det inte mycket till applikation kvar. Därför har jag valt att kolla om det biblioteket är inladdat innan någonting körs, skulle det mot förmodan inte göra det meddelas användaren genom en alert-ruta.

# Hur har du tänkt kring säkerheten i din applikation?
Inga resurser som inte är offentliga ligger publikt, dessa ligger utanför applikationsroten. Det som är tillgängligt publikt är bilder, js, css samt de publika metoder som finns i controller-classerna.

Jag ser ingen anledning till att skapa en intern api-nyckel, men detta är självklart något man kan göra om man känner ett behov av att säkerställa att det bara är "min" applikation som kan se trafikinformationen.

Då inte någonting lagras i en databas eller kräver input från användaren finns det inget sätt att injicera vare sig SQL- eller JavaScript-kod.

# Hur har du tänkt kring optimeringen i din applikation?
Jag har lyckats implementerat en cachning för JSON-anropet. Jag har dock inte lyckats ställa in min webbserver för automatisk cachning av *.css och *.js, vilket självklart är någonting som borde cachas på klienten. Bilderna som används cacheas dock på klienten (bortset från favicon.png av någon anledning).

CSS-filer är placerade i HEAD-taggen samt minifierade, och JS-filer är placerade längst ner i dokumentet och även de minifierade.
