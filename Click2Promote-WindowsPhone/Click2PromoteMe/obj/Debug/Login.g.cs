﻿#pragma checksum "C:\Users\Bojan\Documents\GitHub\click2promote\Click2Promote-WindowsPhone\Click2PromoteMe\Login.xaml" "{406ea660-64cf-4c82-b6f0-42d48172a799}" "4B8A8C85EFC08C45D782FEBD83ACE3FA"
//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated by a tool.
//     Runtime Version:4.0.30319.18051
//
//     Changes to this file may cause incorrect behavior and will be lost if
//     the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

using Microsoft.Phone.Controls;
using System;
using System.Windows;
using System.Windows.Automation;
using System.Windows.Automation.Peers;
using System.Windows.Automation.Provider;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Interop;
using System.Windows.Markup;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Imaging;
using System.Windows.Resources;
using System.Windows.Shapes;
using System.Windows.Threading;


namespace Click2PromoteMe {
    
    
    public partial class Login : Microsoft.Phone.Controls.PhoneApplicationPage {
        
        internal System.Windows.Controls.Grid LayoutRoot;
        
        internal System.Windows.Controls.StackPanel TitlePanel;
        
        internal System.Windows.Controls.TextBlock ApplicationTitle;
        
        internal System.Windows.Controls.TextBlock PageTitle;
        
        internal System.Windows.Controls.Grid ContentPanel;
        
        internal System.Windows.Controls.TextBlock Username;
        
        internal System.Windows.Controls.TextBox txtUsername;
        
        internal System.Windows.Controls.TextBlock Password;
        
        internal System.Windows.Controls.PasswordBox txtPass;
        
        internal System.Windows.Controls.Button btnLogin;
        
        internal System.Windows.Controls.Button txtForgotPassword;
        
        internal System.Windows.Controls.Button txtRegisterOnline;
        
        private bool _contentLoaded;
        
        /// <summary>
        /// InitializeComponent
        /// </summary>
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        public void InitializeComponent() {
            if (_contentLoaded) {
                return;
            }
            _contentLoaded = true;
            System.Windows.Application.LoadComponent(this, new System.Uri("/Click2PromoteMe;component/Login.xaml", System.UriKind.Relative));
            this.LayoutRoot = ((System.Windows.Controls.Grid)(this.FindName("LayoutRoot")));
            this.TitlePanel = ((System.Windows.Controls.StackPanel)(this.FindName("TitlePanel")));
            this.ApplicationTitle = ((System.Windows.Controls.TextBlock)(this.FindName("ApplicationTitle")));
            this.PageTitle = ((System.Windows.Controls.TextBlock)(this.FindName("PageTitle")));
            this.ContentPanel = ((System.Windows.Controls.Grid)(this.FindName("ContentPanel")));
            this.Username = ((System.Windows.Controls.TextBlock)(this.FindName("Username")));
            this.txtUsername = ((System.Windows.Controls.TextBox)(this.FindName("txtUsername")));
            this.Password = ((System.Windows.Controls.TextBlock)(this.FindName("Password")));
            this.txtPass = ((System.Windows.Controls.PasswordBox)(this.FindName("txtPass")));
            this.btnLogin = ((System.Windows.Controls.Button)(this.FindName("btnLogin")));
            this.txtForgotPassword = ((System.Windows.Controls.Button)(this.FindName("txtForgotPassword")));
            this.txtRegisterOnline = ((System.Windows.Controls.Button)(this.FindName("txtRegisterOnline")));
        }
    }
}

