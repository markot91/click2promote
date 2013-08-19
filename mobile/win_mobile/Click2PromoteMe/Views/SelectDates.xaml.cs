using System;
using Click2PromoteMe.ApiData;
using Microsoft.Phone.Controls;
using Microsoft.Phone.Shell;

namespace Click2PromoteMe.Views
{
    public partial class SelectDates : PhoneApplicationPage
    {
        public SelectDates()
        {
            InitializeComponent();
            
            btnSubmit.Tap += btnSubmit_Tap;
        }

        void btnSubmit_Tap(object sender, System.Windows.Input.GestureEventArgs e)
        {
            SystemTray.ProgressIndicator = new ProgressIndicator();
            SystemTray.ProgressIndicator.IsIndeterminate = true;
            SystemTray.ProgressIndicator.IsVisible = true;
            
            DateTime startDate = (DateTime)dpStartDate.Value;
            DateTime endDate = (DateTime)dpEndDate.Value;

            DataService dataService = new DataService();
            dataService.ChartDataIntervalLoaded += dataService_ChartDataIntervalLoaded;
            dataService.GetChartIntervalData(startDate, endDate);
        }

        void dataService_ChartDataIntervalLoaded(object sender, EventArgs e)
        {
            SystemTray.ProgressIndicator.IsVisible = false;
            NavigationService.Navigate(new Uri("/Views/Chart1.xaml", UriKind.Relative));
        }
    }
}