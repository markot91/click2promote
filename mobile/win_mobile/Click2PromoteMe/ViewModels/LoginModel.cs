using System;
using System.Net;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Shapes;

namespace Click2PromoteMe.ViewModels
{
    public class LoginModel
    {
        public string login { get; set; }
        public int user_id { get; set; }
        public int site_id { get; set; }
        public int session { get; set; }
        public string error { get; set; }
    }
}
