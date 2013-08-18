using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Controls.DataVisualization.Charting;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Shapes;
using Click2PromoteMe.ApiData;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;

namespace Click2PromoteMe.Views
{
    public partial class Chart1 : PhoneApplicationPage
    {

        public Chart1()
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
        }

        protected override void OnNavigatedTo(System.Windows.Navigation.NavigationEventArgs e)
        {
            if (App.Providers.Contains(App.FACEBOOK_KEY))
            {
                LineSeries fb = FacebookChart.Series[0] as LineSeries;
                fb.ItemsSource = App.FilteredChartData;
                if (!piMain.Items.Contains(piFacebook))
                {
                    piMain.Items.Add(piFacebook);
                }
            }
            else
            {
                piFacebook.Visibility = Visibility.Collapsed;
                piMain.Items.Remove(piFacebook);
            }

            if (App.Providers.Contains(App.TWITTER_KEY))
            {
                LineSeries tw = TwitterChart.Series[0] as LineSeries;
                tw.ItemsSource = App.FilteredChartData;
                if (!piMain.Items.Contains(piTwitter))
                {
                    piMain.Items.Add(piTwitter);
                }
            }
            else
            {
                piTwitter.Visibility = Visibility.Collapsed;
                piMain.Items.Remove(piTwitter);
            }

            if (App.Providers.Contains(App.YOUTUBE_KEY))
            {
                LineSeries you = YoutubeChart.Series[0] as LineSeries;
                you.ItemsSource = App.FilteredChartData;
                if (!piMain.Items.Contains(piYoutube))
                {
                    piMain.Items.Add(piYoutube);
                }
            }
            else
            {
                piYoutube.Visibility = Visibility.Collapsed;
                piMain.Items.Remove(piYoutube);
            }

            if (App.Providers.Contains(App.BING_KEY))
            {
                LineSeries bing = BingChart.Series[0] as LineSeries;
                bing.ItemsSource = App.FilteredChartData;
                if (!piMain.Items.Contains(piBing))
                {
                    piMain.Items.Add(piBing);
                }
            }
            else
            {
                piBing.Visibility = Visibility.Collapsed;
                piMain.Items.Remove(piBing);
            }

            if (App.Providers.Contains(App.GOOGLE_KEY))
            {
                LineSeries gog = GoogleChart.Series[0] as LineSeries;
                gog.ItemsSource = App.FilteredChartData;
                if (!piMain.Items.Contains(piGoogle))
                {
                    piMain.Items.Add(piGoogle);
                }
            }
            else
            {
                piGoogle.Visibility = Visibility.Collapsed;
                piMain.Items.Remove(piGoogle);
            }

            base.OnNavigatedTo(e);
        }

        private void btnSettings_Click(object sender, EventArgs e)
        {
            NavigationService.Navigate(new Uri("/Views/Settings.xaml", UriKind.Relative));
        }

        private void btnInterval_Click(object sender, EventArgs e)
        {
            NavigationService.Navigate(new Uri("/Views/SelectDates.xaml", UriKind.Relative));
        }
    }
}