import smtplib
import sys

sender = sys.argv[1]
recp = sys.argv[2]
case_id = sys.argv[3]
msg_type = sys.argv[4]

s = smtplib.SMTP()

s.connect('email-smtp.us-east-1.amazonaws.com', 587)

s.starttls()

s.login('AKIAZ2EGK4EUT3PQIFKG','BLrYtZf1zL0j+NZ70zFrhdmMglm5YnixRQje49FVZEXR')

if msg_type =="started":
    msg = 'From: ' + sender + '\nTo: ' + recp + '\nSubject: Analysis started\n\nYour analysis on the IRAP web app has started successfully, and your case id is:' + case_id + '.'

elif msg_type == "finished":
    msg = 'From: ' + sender + '\nTo: ' + recp + '\nSubject: Analysis finished\n\nYour analysis on the IRAP web app has finished. Come to your home page, and check your result. And your case id is:' + case_id + '.'

else:
    raise ValueError("input msg_type is not correct;")

s.sendmail(sender, recp, msg)

