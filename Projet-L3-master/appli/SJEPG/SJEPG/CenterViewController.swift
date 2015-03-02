//
//  ViewController.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit
import Foundation

class CenterViewController: UIViewController {

    
    @IBOutlet weak var menuButton:UIBarButtonItem!
    @IBOutlet weak var dcd: UILabel!
    @IBOutlet var eventsCollection: UICollectionView!
    
    var currentWeek: Int = 0
    var events: NSArray = []
    
    override func viewDidLoad() {
        super.viewDidLoad();
        
        // Observer
        NSNotificationCenter.defaultCenter().addObserver(self, selector: "refresh", name: "GetAgendaDidComplete", object: nil)
        
        if self.revealViewController() != nil {
            menuButton.target = self.revealViewController()
            menuButton.action = "revealToggle:"
            //self.view.addGestureRecognizer(self.revealViewController().panGestureRecognizer())
        }
        self.revealViewController().rearViewRevealWidth = 230
        //ProgressView.shared.showProgressView(view)
        dcd.layer.cornerRadius = 10.0
        dcd.clipsToBounds = true
        
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
        
        getAgenda(currentWeek)
        
        //ProgressView.shared.hideProgressView()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func numberOfSectionsInCollectionView(collectionView: UICollectionView) -> Int {
        return self.events.count
    }
    
    func collectionView(collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return 1
    }
    
    func collectionView(collectionView: UICollectionView, cellForItemAtIndexPath indexPath: NSIndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCellWithReuseIdentifier("cellEventID", forIndexPath: indexPath) as EventCell
        cell.backgroundColor = UIColor.whiteColor()
        
        cell.agendaTitle.text = self.events[indexPath.section]["AgendaTitle"] as NSString
        cell.layer
        cell.agendaType.text = self.events[indexPath.section]["AgendaType"] as NSString
        
        return cell
    }
    
    private let sectionInsets = UIEdgeInsets(top: 10.0, left: 20.0, bottom: 10.0, right: 10.0)
    
    func collectionView(collectionView: UICollectionView!,
        layout collectionViewLayout: UICollectionViewLayout!,
        insetForSectionAtIndex section: Int) -> UIEdgeInsets {
            return sectionInsets
    }
    
    func collectionView(collectionView: UICollectionView!,
        layout collectionViewLayout: UICollectionViewLayout!,
        sizeForItemAtIndexPath indexPath: NSIndexPath!) -> CGSize {
        println("cell size")
        return CGSize(width: 360, height: 120)
    }
    
    
    func respondToSwipeGesture(gesture: UIGestureRecognizer) {
        
        if let swipeGesture = gesture as? UISwipeGestureRecognizer {
            
            switch swipeGesture.direction {
            case UISwipeGestureRecognizerDirection.Right:
                println("Swiped right")
                self.currentWeek--
                getAgenda(currentWeek)
            case UISwipeGestureRecognizerDirection.Left:
                println("Swipe Left")
                self.currentWeek++
                getAgenda(currentWeek)
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
            var strData = NSString(data: data, encoding: NSUTF8StringEncoding)
            //println("Body: \(strData)")
            var err: NSError?
            var json = NSJSONSerialization.JSONObjectWithData(data, options: .MutableLeaves, error: &err) as? NSArray
            
            if(err != nil) {
                println(err!.localizedDescription)
                let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                println("Error could not parse JSON: '\(jsonStr)'")
            } else {
                if let parseJSON = json {
                    NSNotificationCenter.defaultCenter().postNotificationName("GetAgendaDidComplete", object:nil)
                    self.events = parseJSON
                }
                else {
                    let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                    println("Error could not parse JSON: \(jsonStr)")
                }
            }
        }
        task.resume()
    }
    
    func refresh() {
        self.eventsCollection.reloadData()
    }
    
    //close the activity indicator
    func closeActivity() {
        ProgressView.shared.hideProgressView()
    }

}
