//
//  LeftMenuView.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit

class LeftMenuView: UITableViewController{
    
    var lien: String?
    var titre: String?
    var connect: Bool?
 
    override func viewDidLoad() {
        super.viewDidLoad()
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    /*
    * Pour chaque bouton on change les donner et on fais appel a performSegueWithIdentifier
    * Pour changer de view, on passe en parametre la view cible.
    */
    
    @IBAction func entTap(sender: AnyObject) {
        self.lien = "http://ent.univ-fcomte.fr/"
        self.connect = true
        self.titre = "ENT"
        self.performSegueWithIdentifier("ufcWebView", sender: self)
    }
    
    @IBAction func adeTap(sender: AnyObject) {
        self.lien = "http://ent.univ-fcomte.fr/"
        self.connect = true
        self.titre = "ADE"
        self.performSegueWithIdentifier("ufcWebView", sender: self)
    }
    
    @IBAction func moodleTap(sender: AnyObject) {
        self.lien = "http://ent.univ-fcomte.fr/render.userLayoutRootNode.uP?uP_root=u121l1n32"
        self.connect = true
        self.titre = "Moodle"
        self.performSegueWithIdentifier("ufcWebView", sender: self)
    }
    
    @IBAction func webMailTap(sender: AnyObject) {
        self.lien = "https://mail-edu.univ-fcomte.fr/"
        self.connect = true
        self.titre = "WebMail"
        self.performSegueWithIdentifier("ufcWebView", sender: self)
    }
    
    
    @IBAction func sjepgTap(sender: AnyObject) {
        self.lien = "http://sjepg.univ-fcomte.fr/"
        self.connect = false
        self.titre = "SJEPG"
        self.performSegueWithIdentifier("ufcWebView", sender: self)
    }
    
    @IBAction func actualiteTap(sender: AnyObject) {
        self.lien = "https://news.google.fr/"
        self.performSegueWithIdentifier("popUpWeb", sender: self)
    }
    
    @IBAction func ginkoBusTap(sender: AnyObject) {
        self.lien = "http://www.ginko.voyage"
        self.performSegueWithIdentifier("popUpWeb", sender: self)
    }
    
    @IBAction func gonkoTempoTap(sender: AnyObject) {
        self.lien = "http://m.ginkotempo.com/TempoMobile/tempoMobile.do?methode=init"
        self.performSegueWithIdentifier("popUpWeb", sender: self)
    }
    
    /*
    * Fonction permettant de passer des données entre les view
    */
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject!) {
        if segue.identifier == "popUpWeb" {
            var webViewController = segue.destinationViewController as WebViewController
            webViewController.lien = self.lien
        }
        else if segue.identifier == "ufcWebView"{
            var navCon = segue.destinationViewController as UINavigationController
            var webViewController = navCon.viewControllers.first as WebViewControllerUFC
            webViewController.lien = self.lien
            webViewController.titre = self.titre
            webViewController.connect = self.connect
        }
    }
}

