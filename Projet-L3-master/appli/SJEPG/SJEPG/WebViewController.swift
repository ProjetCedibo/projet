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
    
    override func viewDidLoad() {
        super.viewDidLoad();
        var url = NSURL(string:"http://www.kinderas.com/")
        var req = NSURLRequest(URL:url!)
        webView.loadRequest(req)
    
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
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
    
    
    @IBAction func stop(AnyObject) {
        webView.stopLoading()
    }
    
    
    

}
