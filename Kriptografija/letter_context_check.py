f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

target = "A"
for i in range(len(text)):
    if text[i] == target:
        before = text[max(0, i - 3):i]
        after = text[i + 1:i + 4]
        print(before, "[" + target + "]", after)