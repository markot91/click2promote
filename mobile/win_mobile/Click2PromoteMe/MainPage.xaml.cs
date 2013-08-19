using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Shapes;
using Click2PromoteMe.Helpers;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;

namespace Click2PromoteMe
{
    public partial class MainPage : PhoneApplicationPage
    {
        // Constructor
        public MainPage()
        {
            InitializeComponent();


            ApplicationBar = new ApplicationBar();

            ApplicationBar.Mode = ApplicationBarMode.Default;
            ApplicationBar.Opacity = 1.0;
            ApplicationBar.IsVisible = true;
            ApplicationBar.IsMenuEnabled = true;

            ApplicationBarIconButton btnInterval = new ApplicationBarIconButton();
            btnInterval.IconUri = new Uri("/Toolkit.Content/edit.PNG", UriKind.Relative);
            btnInterval.Text = "Chose interval";
            btnInterval.Click += new EventHandler(btnInterval_Click);
            ApplicationBar.Buttons.Add(btnInterval);

            ApplicationBarIconButton btnSettings = new ApplicationBarIconButton();
            btnSettings.IconUri = new Uri("/Toolkit.Content/settings.PNG", UriKind.Relative);
            btnSettings.Text = "Settings";
            btnSettings.Click += new EventHandler(btnSettings_Click);
            ApplicationBar.Buttons.Add(btnSettings);

            // Set the data context of the listbox control to the sample data
            DataContext = App.ViewModel;
            //add default providers: facebook, twitter and youtube
            App.Providers.Add(App.FACEBOOK_KEY);
            App.Providers.Add(App.TWITTER_KEY);
            App.Providers.Add(App.YOUTUBE_KEY);
            this.Loaded += new RoutedEventHandler(MainPage_Loaded);
        }

        private void btnSettings_Click(object sender, EventArgs e)
        {
            NavigationService.Navigate(new Uri("/Views/Settings.xaml", UriKind.Relative));
        }

        private void btnInterval_Click(object sender, EventArgs e)
        {
            NavigationService.Navigate(new Uri("/Views/SelectDates.xaml", UriKind.Relative));
        }


        // Handle selection changed on ListBox
        private void MainListBox_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {
            
        }

        // Load data for the ViewModel Items
        private void MainPage_Loaded(object sender, RoutedEventArgs e)
        {
            if (App.Providers == null)
            {
                AppDataStore store = new AppDataStore();
                App.Providers = store.GetAppSettings();
            }
            this.spData.DataContext = App.BasicChartData[0];
        }
    }
}