//
//  WebViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 20/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit
import WebKit

class WebViewController: UIViewController {
    
    @IBOutlet var webView: UIWebView!
    var lien : String?
    var connect: Bool?
    
    override func viewDidLoad() {
        super.viewDidLoad();
        loadweb()
    }
    
    /*
    * Fonction permettant de charger la webView
    */
    func loadweb() {
        var url = NSURL(string:lien!)
        var req = NSURLRequest(URL:url!)
        
        webView.loadRequest(req)
    }
    
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    /*
    * Fonction permettant de raffrechir la page
    */
    @IBAction func doRefresh(AnyObject) {
        webView.reload()
    }
    
    /*
    * Fonction permettant de revenir a la page précédante
    */
    @IBAction func goBack(AnyObject) {
        webView.goBack()
    }
    
    /*
    * Fonction permettant de revenir a la page suivante
    */
    @IBAction func goForward(AnyObject) {
        webView.goForward()
    }
    
    /*
    * Fonction permettant de fermer la page (au clique sur la croix)
    */
    @IBAction func closeView(sender: AnyObject) {
        dismissViewControllerAnimated(true, completion: nil)
    }
    


}
