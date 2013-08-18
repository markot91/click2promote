using System;
using Click2PromoteMe.ApiData;
using Microsoft.Phone.Controls;
using System.Windows;
using Microsoft.Phone.Tasks;
using Microsoft.Phone.Shell;

namespace Click2PromoteMe
{
    public partial class Login : PhoneApplicationPage
    {        
        public Login()
        {
            InitializeComponent();

            btnLogin.Tap += btnLogin_Tap;
        }

        void btnLogin_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            SystemTray.ProgressIndicator = new ProgressIndicator();
            SystemTray.ProgressIndicator.IsIndeterminate = true;
            SystemTray.ProgressIndicator.IsVisible = true;

            DataService dataService = new DataService();
            
            dataService.ChartDataLoaded += DataServiceChartDataLoaded;
            dataService.LoginFailed += DataServiceLoginFailed;
            dataService.LoginToApi(txtUsername.Text, txtPass.Password);
        }

        void DataServiceLoginFailed(object sender, EventArgs e)
        {
            if (App.LoginMessage != null) MessageBox.Show(App.LoginMessage);
        }

        void DataServiceChartDataLoaded(object sender, EventArgs e)
        {
            // Charts view
            //NavigationService.Navigate(new Uri("/Views/SelectDates.xaml", UriKind.Relative));

            SystemTray.ProgressIndicator.IsVisible = false;
            //Main list view
            NavigationService.Navigate(new Uri("/MainPage.xaml", UriKind.Relative));
        }

        private void txtForgotPassword_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            WebBrowserTask webBrowserTask = new WebBrowserTask();
            webBrowserTask.Uri = new Uri(App.FORGOT_PASS_URL);
            webBrowserTask.Show();
        }

        private void txtRegisterOnline_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            WebBrowserTask webBrowserTask = new WebBrowserTask();
            webBrowserTask.Uri = new Uri(App.REGISTER_URL);
            webBrowserTask.Show();
        }
    }
}