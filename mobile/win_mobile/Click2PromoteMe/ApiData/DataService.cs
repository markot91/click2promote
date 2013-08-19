using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.IO;
using System.Net;
using System.Windows.Navigation;
using Click2PromoteMe.Helpers;
using Click2PromoteMe.ViewModels;
using Newtonsoft.Json;
using Newtonsoft.Json.Converters;
using Newtonsoft.Json.Schema;
using Newtonsoft.Json.Serialization;
using WindowsPhonePostClient;

namespace Click2PromoteMe.ApiData
{
    public delegate void ChartDataLoadedHandler(object sender, EventArgs e);

    public class DataService
    {
        public event ChartDataLoadedHandler LoginFailed;

        public void InvokeLoginFailed(EventArgs e)
        {
            ChartDataLoadedHandler handler = LoginFailed;
            if (handler != null) handler(this, e);
        }

        public event ChartDataLoadedHandler ChartDataLoaded;

        public void InvokeChartDataLoaded(EventArgs e)
        {
            ChartDataLoadedHandler handler = ChartDataLoaded;
            if (handler != null)
            {
                handler(this, e);
            }
        }

        public event ChartDataLoadedHandler ChartDataIntervalLoaded;

        public void InvokeChartDataIntervalLoaded(EventArgs e)
        {
            ChartDataLoadedHandler handler = ChartDataIntervalLoaded;
            if (handler != null) handler(this, e);
        }

        public void LoginToApi(string username, string password)
        {
            Uri webUri = new Uri(App.LOGIN_URL, UriKind.Absolute);

            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("username", username);
            parameters.Add("password", password);
            
            PostClient proxy = new PostClient(parameters);
            proxy.DownloadStringCompleted += (sender, e) =>
            {
                if (e.Error == null)
                {
                    LoginModel loginData = (LoginModel)JsonConvert.DeserializeObject(e.Result, typeof(LoginModel));
                    if(loginData.login.ToLower() == "fail" && !string.IsNullOrEmpty(loginData.error))
                    {
                        App.LoginMessage = loginData.error;
                        InvokeLoginFailed(null);
                        return;
                    }
                    App.SessionId = loginData.session;
                    App.UserId = loginData.user_id;
                    GetSiteId(loginData.session, loginData.user_id);
                }
            };
            proxy.DownloadStringAsync(webUri);
        }

        /// <summary>
        /// Retrive site id for loged in user
        /// </summary>
        /// <param name="sessionId"></param>
        /// <param name="userId"></param>
        private void GetSiteId(int sessionId, int userId)
        {
            Uri webUri = new Uri(App.GET_SITE_ID_URL, UriKind.Absolute);

            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("session_id", sessionId);
            parameters.Add("user_id", userId);

            PostClient proxy = new PostClient(parameters);
            proxy.DownloadStringCompleted += (sender, e) =>
            {
                if (e.Error == null)
                {
                    LoginModel loginData = (LoginModel)JsonConvert.DeserializeObject(e.Result, typeof(LoginModel));
                    App.SiteId = loginData.site_id;
                    GetChartData(loginData.session, loginData.site_id);
                }
            };
            proxy.DownloadStringAsync(webUri);
        }

        /// <summary>
        /// Retrive data for the chart from the api
        /// </summary>
        /// <param name="sessionId"></param>
        /// <param name="siteId"></param>
        private void GetChartData(int sessionId, int siteId)
        {
            Uri webUri = new Uri(App.GET_CHART_URL, UriKind.Absolute);

            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("session_id", App.SessionId);
            parameters.Add("user_id", App.UserId);
            parameters.Add("site_id", siteId);

            PostClient proxy = new PostClient(parameters);
            proxy.DownloadStringCompleted += (sender, e) =>
            {
                if (e.Error == null)
                {
                    List<string> errors =new List<string>();
                    List<ChartViewModel> chartData = JsonConvert.DeserializeObject<List<ChartViewModel>>(e.Result, 
                                                        new JsonSerializerSettings
                                                          {
                                                              Error = delegate(object sen, ErrorEventArgs args)
                                                                {
                                                                errors.Add(args.ErrorContext.Error.Message);
                                                                args.ErrorContext.Handled = true;
                                                                }
                                                          });
                    
                    App.BasicChartData = chartData;

                    InvokeChartDataLoaded(null);
                }
            };
            proxy.DownloadStringAsync(webUri);

        }

        public void GetChartIntervalData(DateTime startDate, DateTime endDate)
        {
            Uri webUri = new Uri(App.GET_CHART_INTERVAL_URL, UriKind.Absolute);

            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("session_id", App.SessionId);
            parameters.Add("user_id", App.UserId);
            parameters.Add("site_id", App.SiteId);
            parameters.Add("from", startDate.ToString("yyyy-MM-dd"));
            parameters.Add("to", endDate.ToString("yyyy-MM-dd"));

            PostClient proxy = new PostClient(parameters);
            proxy.DownloadStringCompleted += (sender, e) =>
            {
                if (e.Error == null)
                {
                    List<string> errors = new List<string>();
                    List<ChartViewModel> chartData = JsonConvert.DeserializeObject<List<ChartViewModel>>(e.Result,
                                                        new JsonSerializerSettings
                                                        {
                                                            Error = delegate(object sen, ErrorEventArgs args)
                                                            {
                                                                errors.Add(args.ErrorContext.Error.Message);
                                                                args.ErrorContext.Handled = true;
                                                            }
                                                        });

                    App.FilteredChartData = chartData;

                    InvokeChartDataIntervalLoaded(null);
                }
            };
            proxy.DownloadStringAsync(webUri);
        }

        /// <summary>
        /// Logout from the api
        /// </summary>
        public void LogOut()
        {
            Uri webUri = new Uri(App.LOGIN_URL, UriKind.Absolute);

            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("session_id", App.SessionId);
            parameters.Add("user_id", App.UserId);

            PostClient proxy = new PostClient(parameters);
            proxy.DownloadStringCompleted += (sender, e) =>
            {
                if (e.Error == null)
                {
                    LoginModel loginData = (LoginModel)JsonConvert.DeserializeObject(e.Result, typeof(LoginModel));
                    GetSiteId(loginData.session, loginData.user_id);
                }
            };
            proxy.DownloadStringAsync(webUri);
        }
    }
}
