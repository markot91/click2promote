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
using Microsoft.Phone.Controls;

namespace Click2PromoteMe.Views
{
    public partial class Settings : PhoneApplicationPage
    {
        public Settings()
        {
            
            InitializeComponent();

            cbFacebook.IsChecked = App.Providers.Contains(App.FACEBOOK_KEY);
            cbYoutube.IsChecked = App.Providers.Contains(App.YOUTUBE_KEY);
            cbGoogle.IsChecked = App.Providers.Contains(App.GOOGLE_KEY);
            cbBing.IsChecked = App.Providers.Contains(App.BING_KEY);
            cbTwitter.IsChecked = App.Providers.Contains(App.TWITTER_KEY);
        }

        /// <summary>
        /// Method that should add or remove providers (charts)
        /// </summary>
        /// <param name="providerName"></param>
        private void AddRemoveProvider(string providerName)
        {
            if (App.Providers.Contains(providerName))
            {
                App.Providers.Remove(providerName);
            }
            else
            {
                App.Providers.Add(providerName);
            }
        }

        private void cbTwitter_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            AddRemoveProvider(App.TWITTER_KEY);
        }

        private void cbFacebook_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            AddRemoveProvider(App.FACEBOOK_KEY);
        }

        private void cbYoutube_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            AddRemoveProvider(App.YOUTUBE_KEY);
        }

        private void cbGoogle_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            AddRemoveProvider(App.GOOGLE_KEY);
        }

        private void cbBing_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            AddRemoveProvider(App.BING_KEY);
        }

    }
}