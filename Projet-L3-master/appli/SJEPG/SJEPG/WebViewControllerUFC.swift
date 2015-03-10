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
        webViewDidFinishLoad(self.webView)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func loadWeb(){
        
        //Lien vers le cas de la faq si le site nécésite une connection
        if connect==true{
            lien = "https://cas.univ-fcomte.fr/cas/login?service=" + lien!
        }
        var url = NSURL(string:lien!)
        var req = NSURLRequest(URL:url!)
        webView.loadRequest(req)

    }
    
    
    /*
    * Fonction permettant de rempplire les champs automatiquement (ne fonctionne pas)
    */
    func webViewDidFinishLoad(webView: UIWebView!) {
        
        let user = NSUserDefaults.standardUserDefaults().stringForKey("userName")
        let pass = NSUserDefaults.standardUserDefaults().stringForKey("passWord")
        println(user)
        
        if user == nil || pass == nil {return}
        
        if ( countElements(user!) != 0 && countElements(pass!) != 0) {
            let loadUsernameJS = "var inputFields = document.querySelectorAll(\"input[name='username']\"); \\ for (var i = inputFields.length >>> 0; i--;) { inputFields[i].value = \'\(user)\';}"
            let loadPasswordJS = "var inputFields = document.querySelectorAll(\"input[name='password']\"); \\ for (var i = inputFields.length >>> 0; i--;) { inputFields[i].value = \'\(pass)\';}"
            
            self.webView.stringByEvaluatingJavaScriptFromString(loadUsernameJS)
            self.webView.stringByEvaluatingJavaScriptFromString(loadPasswordJS)
            
            let result = webView.stringByEvaluatingJavaScriptFromString("document.title")
            println("\(result!)")
            println("yo")
        }
        //println("yo")
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
