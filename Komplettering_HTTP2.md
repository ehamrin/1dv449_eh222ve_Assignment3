#Komplettering teori HTTP/2
**Erik Hamrin (eh222ve)**

##Vad är det
HTTP/2 är en uppdatering av HTTP-protokollet som behåller kärnkoncepten från HTTP 1.1 såsom HTTP-headers, statuskoder, och URIs. Den nya uppdateringen är byggd på SPDYs om utvecklades av Google under 2009[3]

##Stöd
HTTP/2 stöds i de flesta webbläsare [1], bakåtkompabiliteten är dålig för framför allt IE och Safari.
Det saknas stöd i Android browser och Opera Mini (surprise!) 

##Anrop
Flera anrop går att göra över samma TCP-uppkoppling mot servern, och svar kan tas emot i en annan ordning än den som skickades. Detta leder till att servern kan optimera sin hantering av interna resurser för att se till att resurserna skickas tillbaka så fort som möjligt. [2]

###HTTP Response
Headern i HTTP/2 är komprimerad och är storleksmässigt drastiskt förminskad. [2]

##Push
Servern pusha resurser till klienten utan att klienten har behövt efterfråga den, detta leder till att servern inte behöver vänta på att klienten ska analysera det första svaret för att fråga efter resurser, utan servern kan direkt pusha resurser som den vet att klienten är beroende utav. [4]

##Kryptering
HTTP/2 kräver i sig inte att uppkopplingen mot servern är krypterad, dock finns det inga webbläsare idag som stöder HTTP/2 okrypterat. [5]

##Arbetssätt
En del av det vi lärt oss under programmet är sådant som man inte ska göra i HTTP2, t.ex. använda sig av image sprites, baka ihop olika CSS/Javascript-filer till en enda fil då det i HTTP/2 blir onödigt. [2]

##Sammanfattning
HTTP/2 kommer drastiskt att sänka tiden det tar för en webbläsare att hämta en webbsida genom olika tekniker, men den mest avgörande tror jag är att webbläsaren kan behålla en och samma uppkopling till servern och att servern kan pusha innehåll till webbläsaren.

Jag tycker att det är bra att webbläsarna håller sig till HTTPS vilket kommer att leda till att fler och fler webbsidor kör krypterat innehåll.

Det kommer att ta tid innan majoriteten av alla webbsidor kör HTTP/2, men nu finns möjligheten att börja använda det i och med att det flesta webbläsare har stöd för det, det blir dock viktigt att ha en fallback mot HTTP 1.1 så att användarna inte störs av bytet.

##Referenser
[1] [http://caniuse.com/#feat=http2](http://caniuse.com/#feat=http2 "http://caniuse.com/#feat=http2") [Hämtad: 3 januari 2016]

[2] [https://http2.akamai.com/](https://http2.akamai.com/ "https://http2.akamai.com/") [Hämtad: 3 janurari 2016]

[3] [http://chimera.labs.oreilly.com/books/1230000000545/ch12.html](http://chimera.labs.oreilly.com/books/1230000000545/ch12.html "http://chimera.labs.oreilly.com/books/1230000000545/ch12.html") [Hämtad: 3 janurari 2016]

[4] [http://apiux.com/2013/07/23/http2-0-initial-draft-released/](http://apiux.com/2013/07/23/http2-0-initial-draft-released/ "http://apiux.com/2013/07/23/http2-0-initial-draft-released/") [Hämtad: 3 janurari 2016]

[5] [https://www.mnot.net/blog/2015/06/15/http2_implementation_status](https://www.mnot.net/blog/2015/06/15/http2_implementation_status "https://www.mnot.net/blog/2015/06/15/http2_implementation_status") [Hämtad: 3 janurari 2016]
