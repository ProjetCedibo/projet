//
//  AppDelegate.swift
//  SJEPG
//
//  Created by petetin cédric on 15/01/2015.
//  Copyright (c) 2015 Petetin Cédric & Akrach Ibrahim. All rights reserved.
//

import UIKit

@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate {

    var window: UIWindow?


    func application(application: UIApplication, didFinishLaunchingWithOptions launchOptions: [NSObject: AnyObject]?) -> Bool {
        
        addUserOrConnextion()
        
        //Notifiaction
        application.applicationIconBadgeNumber = 0
        var dev = UIDevice.currentDevice().identifierForVendor.UUIDString
        println( dev)
        
        //Enregistrement pour les notification en fonction de la version de l'os
        if dev >= "8.0" {
            // Register for push in iOS 8
            var types: UIUserNotificationType = UIUserNotificationType.Badge |
                UIUserNotificationType.Alert |
                UIUserNotificationType.Sound
            var settings: UIUserNotificationSettings = UIUserNotificationSettings( forTypes: types, categories: nil )
            application.registerUserNotificationSettings( settings )
            application.registerForRemoteNotifications()
        }else{
            // Register for push in iOS 7
            application.registerForRemoteNotificationTypes( UIRemoteNotificationType.Badge |
                UIRemoteNotificationType.Sound |
                UIRemoteNotificationType.Alert )
            
        }
        
        
        // Override point for customization after application launch.
        return true
    }
    
    /*
    * Fonction permettant d'envoyer le Token a la base de données, ce qui nous permet d'envoyer les notifications par la suite.
    */
    func application( application: UIApplication!, didRegisterForRemoteNotificationsWithDeviceToken deviceToken: NSData! ) {
        var characterSet: NSCharacterSet = NSCharacterSet( charactersInString: "<>" )
        var deviceTokenString: String = ( deviceToken.description as NSString )
            .stringByTrimmingCharactersInSet( characterSet )
            .stringByReplacingOccurrencesOfString( " ", withString: "" ) as String
        println( deviceTokenString )
        
        let UUID = UIDevice.currentDevice().identifierForVendor.UUIDString
        var device = UIDevice.currentDevice().model
        
        let myUrl = NSURL(string: "http://sjepg.byethost7.com/php/notif.php");
        
        let request = NSMutableURLRequest(URL:myUrl!);
        request.HTTPMethod = "POST";
        
        // On passe en données post l'UUID du téléphone et le Token.
        let postString = "DeviceID=\(UUID)&Token=\(deviceTokenString)";//
        
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding);
        
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            
            if error != nil
            {
                println("error=\(error)")
                return
            }

            let responseString = NSString(data: data, encoding: NSUTF8StringEncoding)
        }
        
        task.resume()
    }
    
    /*
    * Fonction appeler en cas d'erreur au niveau des notifications
    */
    func application( application: UIApplication!, didFailToRegisterForRemoteNotificationsWithError error: NSError! ) {
        println( error.localizedDescription )
    }
    
    
    /*
    * Fonction permettant d'ajouter un utilisateur a la base de données lors de la premiere utilisation.
    * et on ajoute une connection a l'utilisateur qui vient de lancer l'application.
    */
    func addUserOrConnextion(){
        let UUID = UIDevice.currentDevice().identifierForVendor.UUIDString
        var device = UIDevice.currentDevice().model
        var devOS = UIDevice.currentDevice().systemVersion
        
        
        let myUrl = NSURL(string: "http://sjepg.byethost7.com/php/register-user.php");
        
        let request = NSMutableURLRequest(URL:myUrl!);
        request.HTTPMethod = "POST";
        
        // Envois des données
        let postString = "DeviceID=\(UUID)&DeviceModel=\(device)&DeviceOS=\(devOS)";//
        
        request.HTTPBody = postString.dataUsingEncoding(NSUTF8StringEncoding);
        
        let task = NSURLSession.sharedSession().dataTaskWithRequest(request) {
            data, response, error in
            
            if error != nil
            {
                println("error=\(error)")
                return
            }

            let responseString = NSString(data: data, encoding: NSUTF8StringEncoding)
                        
        }
        
        task.resume()
    }

    func applicationWillResignActive(application: UIApplication) {
        // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
        // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
    }

    func applicationDidEnterBackground(application: UIApplication) {
        // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
        // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    }

    func applicationWillEnterForeground(application: UIApplication) {
        // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
    }

    func applicationDidBecomeActive(application: UIApplication) {
        // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    }

    func applicationWillTerminate(application: UIApplication) {
        // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
        
    }


}

