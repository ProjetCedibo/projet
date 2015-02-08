//
//  ViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit
import Foundation

@objc
protocol CenterViewControllerDelegate {
    optional func toggleLeftPanel()
    optional func collapseSidePanels()
}


class CenterViewController: UIViewController {

    
    var delegate: CenterViewControllerDelegate?
    
    override func viewDidLoad() {
        super.viewDidLoad();
        //ProgressView.shared.showProgressView(view)
        addUserOrConnextion()
        
        //ProgressView.shared.hideProgressView()
    }
    
    
    func addUserOrConnextion(){
        let UUID = UIDevice.currentDevice().identifierForVendor.UUIDString
        var device = UIDevice.currentDevice().model
        var devOS = UIDevice.currentDevice().systemVersion
        println(device)
        var bodyData = "\nDeviceID=\(UUID)"
        println(bodyData)
        
        let myUrl = NSURL(string: "http://localhost:8888/php/register-user.php");
        
        let request = NSMutableURLRequest(URL:myUrl!);
        request.HTTPMethod = "POST";
        
        // Compose a query string
        let postString = "DeviceID=\(UUID)&DeviceModel=\(device)&DeviceOS=\(devOS)";//
        
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding);
        
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            
            if error != nil
            {
                println("error=\(error)")
                return
            }
            
            // You can print out response object
            println("response = \(response)")
            
            // Print out response body
            let responseString = NSString(data: data, encoding: NSUTF8StringEncoding)
            println("responseString = \(responseString)")
            
            
        }
        
        task.resume()
    }
    
    // MARK: Button actions
    
    @IBAction func ShowLeftMenu(sender: AnyObject) {
        delegate?.toggleLeftPanel?()
    }

}
