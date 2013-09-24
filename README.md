# mediarss-maker

---

MediaRSS Maker is a PHP script design to create MediaRSS feeds by screen
scraping popular image sites.

Simply pass the script a url of a page you'd like a feed for, and if the site is
supported, it will return a valid MediaRSS feed, that you can use in whatever
application supports consumption of such feeds (e.g., the
[Variety Wallpaper Changer](http://peterlevi.com/variety/)).

E.g., this URL should give you a feed of wallbase.cc's top list:
http://example.com/path/to/mediarss-maker/?url=http%3A%2F%2Fwallbase.cc%2Ftoplist

It's designed to be modular, so that new sites can be easily added. It currently
supports [wallbase](http://wallbase.cc) and [reddit](http://reddit.com). The
reddit engine will work with any subreddits to which images are posted, and have
a resolution in the title.
