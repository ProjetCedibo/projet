//
//  WebViewControllerUFC.swift
//  SJEPG
//
//  Created by petetin cédric on 28/02/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit

class WebViewControllerUFC: UIViewController {
    
    var titre: String?
    var lien: String?
    var connect: Bool?
    
    @IBOutlet weak var menuButton:UIBarButtonItem!
    @IBOutlet weak var webView: UIWebView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = titre
        loadWeb()
        
        if self.revealViewController() != nil {
            menuButton.target = self.revealViewController()
            menuButton.action = "revealToggle:"
            self.view.addGestureRecognizer(self.revealViewController().panGestureRecognizer())
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func loadWeb(){
        var user: String? = NSUserDefaults.standardUserDefaults().stringForKey("userName")
        var pass: String? = NSUserDefaults.standardUserDefaults().stringForKey("passWord")
        //if connect == true{
            //lien = "https://cas.univ-fcomte.fr/cas/login?service=" + lien!
            var url = NSURL(string:lien!)
            var req = NSURLRequest(URL:url!)
            //req.HTTPMethod = "post"
            
        /*}
        else{
            var url = NSURL(string:lien!)
            var req = NSURLRequest(URL:url!)
        }*/
        
        webView.loadRequest(req)
    }
    
    @IBAction func doRefresh(AnyObject) {
        webView.reload()
    }
    
    
    @IBAction func goBack(AnyObject) {
        webView.goBack()
    }
    
    
    @IBAction func goForward(AnyObject) {
        webView.goForward()
    }
    

}
