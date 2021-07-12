# Email a random XKCD challenge

It's a simple PHP application that accepts visitor's email addresses and quickly sends a verification mail user.The user can verify himself by clicking on the link provided in that email.
once the user is verified this web app sends a random XKCD webcomic to the provided email id every 5 minutes.
The comic is sent as an email attachment as well as inline image content.
Users can unsubscribe from these recurring emails at any point of time. Unsubscribe link is sent with the comic e-mail itself.

## Features

- Unique activation code for each user
- Activation code encrypted with AES-128bit
- Basic prevention against XSS(cross-site scripting) vulnerabilities
- Basic prevention against SQL injection vulnerabilities
- User verification through email
- Unsubscribe link with webcomic itself
- Checked against various test cases
- Mobile friendly

## Tech Stack

**Client:** HTML, CSS, Javascript

**Server:** PHP

**API:** <a href="https://sendgrid.com/solutions/email-api/">Sendgrid</a>, <a href="https://xkcd.com/">XKCD</a>

**Hosting platform:** <a href="https://www.heroku.com/">Heroku</a>

**Heroku-buildpack:** <a href="https://github.com/timanovsky/subdir-heroku-buildpack">subdir-heroku-buildpack</a> (for hosting a subfolder on heroku)

**CORS:** <a href="https://cors-anywhere.herokuapp.com/corsdemo">cors-anywhere</a>

## Work-flow

<img src="./Assets/Images/workflow.png"alt="can't">
