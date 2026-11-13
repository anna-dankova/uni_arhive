f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

# Our guesses: cipher letter -> plain letter
key = {"A": "j", "V": "e", "G": "a", "L":"n","Ž":"i","B":"l", "M":"b", "I":"o", "S": "č", "O": "v", "Č": "s", "F":"p", "N":"k" , "D":"m", "E":"t", "Z":"u","C":"š","P":"g","R":"r", "K":"h", "T":"d", "H":"z", "U":"ž", "J":"c"}

result = ""
for letter in text:
    if letter in key:
        result = result + key[letter]
    else:
        result = result + letter

print(result)