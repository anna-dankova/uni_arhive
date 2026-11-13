f = open("TAJNOPIS2.txt", encoding="utf-8")
text = f.read().strip()
f.close()

target = "AV"
for i in range(len(text) - 1):
    if text[i] + text[i + 1] == target:
        before = text[max(0, i - 4):i]
        after = text[i + 2:i + 6]
        print(before, "[" + target + "]", after)