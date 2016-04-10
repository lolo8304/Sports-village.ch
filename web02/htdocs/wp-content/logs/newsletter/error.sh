awk '/mail> To: /{mm=$0;getline;getline;print mm ", " $0;}' main-dea2a796.txt | grep "mail>" | grep "2016" > mails.txt
echo "650 - SPAM"
grep '(650)' mails.txt
echo "............................................."
echo "error sending mail"
grep '(510)' mails.txt
echo "............................................."
echo "other error"
cat mails.txt | grep ERROR | grep -v "(510)" | grep -v "(650"
echo "............................................."
echo "see mail.txt"

