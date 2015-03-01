//
//  AgendaViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 01/03/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit
import Foundation

class AgendaViewController: UITableViewController {
    
    var currentWeek: Int?
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let calendar = NSCalendar.currentCalendar()
        let date = NSDate()
        let components = calendar.components(.MonthCalendarUnit | .DayCalendarUnit, fromDate: date)

        currentWeek = calendar.component(.CalendarUnitWeekOfYear, fromDate: date)
        currentWeek = currentWeek as NSInteger!
        println(currentWeek)
        
        var swipeRight = UISwipeGestureRecognizer(target: self, action: "respondToSwipeGesture:")
        swipeRight.direction = UISwipeGestureRecognizerDirection.Right
        self.view.addGestureRecognizer(swipeRight)
        
        var swipeLeft = UISwipeGestureRecognizer(target: self, action: "respondToSwipeGesture:")
        swipeLeft.direction = UISwipeGestureRecognizerDirection.Left
        self.view.addGestureRecognizer(swipeLeft)
        
        
        getAgenda(currentWeek!)
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    
    func respondToSwipeGesture(gesture: UIGestureRecognizer) {
        
        if let swipeGesture = gesture as? UISwipeGestureRecognizer {
            
            switch swipeGesture.direction {
            case UISwipeGestureRecognizerDirection.Right:
                println("Swiped right")
            case UISwipeGestureRecognizerDirection.Left:
                println("Swipe Left")
            default:
                break
            }
        }
    }
    

    func getAgenda(week: Int){
        
        //let myURL = NSURL(string: "http://localhost:8888/php/getAgenda.php")!
        let myURL = NSURL(string: "http://sjepg.byethost7.com/php/getAgenda.php")!
        let request = NSMutableURLRequest(URL: myURL)
        request.HTTPMethod = "POST"
        
        request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
        request.setValue("application/json", forHTTPHeaderField: "Accept")
        let bodyStr:String = "Week=\(week)"
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
                    //self.dcd.text = parseJSON["AgendaMessage"] as NSString
                    var type = parseJSON["AgendaType"] as NSString
                    println(type)
                    /*if type.isEqual("BU"){
                        self.dcd.backgroundColor = UIColor.cyanColor()
                    }else if (type.isEqual("sjepg")){
                        self.dcd.backgroundColor = UIColor.redColor()
                    }else{
                        self.dcd.backgroundColor = UIColor.greenColor()
                    }*/
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

}
