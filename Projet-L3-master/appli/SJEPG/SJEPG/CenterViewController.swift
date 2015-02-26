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
    
    @IBOutlet weak var dcd: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad();
        //ProgressView.shared.showProgressView(view)
        dcd.layer.cornerRadius = 10.0
        dcd.clipsToBounds = true
        addUserOrConnextion()
        getAgenda(7)
        
        //ProgressView.shared.hideProgressView()
    }
    
    func getAgenda(week: Int){
        
        //let myURL = NSURL(string: "http://localhost:8888/php/getAgenda.php")!
        let myURL = NSURL(string: "http://sjepg.byethost7.com/php/getAgenda.php")!
        let request = NSMutableURLRequest(URL: myURL)
        request.HTTPMethod = "POST"
        
        request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
        request.setValue("application/json", forHTTPHeaderField: "Accept")
        let bodyStr:String = "Week=7"
        request.HTTPBody = bodyStr.dataUsingEncoding(NSUTF8StringEncoding)
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            
            println("Response: \(response)")
            var strData = NSString(data: data, encoding: NSUTF8StringEncoding)
            println("Body: \(strData)")
            var err: NSError?
            var json = NSJSONSerialization.JSONObjectWithData(data, options: .MutableLeaves, error: &err) as? NSDictionary
            
            // Did the JSONObjectWithData constructor return an error? If so, log the error to the console
            if(err != nil) {
                println(err!.localizedDescription)
                let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                println("Error could not parse JSON: '\(jsonStr)'")
            }
            else {
                // The JSONObjectWithData constructor didn't return an error. But, we should still
                // check and make sure that json has a value using optional binding.
                if let parseJSON = json {
                    // Okay, the parsedJSON is here, let's get the value for 'success' out of it
                    var success = parseJSON["success"] as? Int
                    println("Succes: \(parseJSON)")
                    self.dcd.text = parseJSON["AgendaMessage"] as NSString
                    var type = parseJSON["AgendaType"] as NSString
                    println(type)
                    if type.isEqual("BU"){
                        self.dcd.backgroundColor = UIColor.cyanColor()
                    }else if (type.isEqual("sjepg")){
                        self.dcd.backgroundColor = UIColor.redColor()
                    }else{
                        self.dcd.backgroundColor = UIColor.greenColor()
                    }
                }
                else {
                    // Woa, okay the json object was nil, something went worng. Maybe the server isn't running?
                    let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                    println("Error could not parse JSON: \(jsonStr)")
                }
            }
        }
        task.resume()
        //closeActivity()
        
    }
    

    
    func addUserOrConnextion(){
        let UUID = UIDevice.currentDevice().identifierForVendor.UUIDString
        var device = UIDevice.currentDevice().model
        var devOS = UIDevice.currentDevice().systemVersion
        println(device)
        var bodyData = "\nDeviceID=\(UUID)"
        println(bodyData)
        
        //let myUrl = NSURL(string: "http://localhost:8888/php/register-user.php");
        let myUrl = NSURL(string: "http://sjepg.byethost7.com/php/register-user.php");
        
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
    
    //close the activity indicator
    func closeActivity() {
        ProgressView.shared.hideProgressView()
    }

}
