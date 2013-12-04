usher
=====

A Web UI for your HTPC

About
----
This is a small hacked-together project I've been working on to serve as a UI
for my Plex Media Server.  As I'm primarily a front-end dev, I'm quite sure there 
are numerous bugs, security issues, memory leaks, and more.  I'm hoping that 
the community can help improve this project!

Known Issues
---
This is tightly integrated to my particular set up right now.  My "To-dos" are 
nested throughout the files, and I've only made first-pass attempts at 
abstracting variables out.  You'll find code mixed between PHP, Javascript, 
and more right now, but I'm learning how to clean things up day by day!

To Do
-----
+ Abstract out user configurable variables to a single php conf / JS conf file
+ Background switcher with javascript / no page reload
+ Clean up some of the JSON responses (especially auth)
+ Browser (file browser) needs SO much work
+ Make sure weather is configurable for users (how to handle api key?)
+ Weather > flat file - make sure permissions are valid before attempting to write