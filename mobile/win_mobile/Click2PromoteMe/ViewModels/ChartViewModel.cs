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
    public class ChartViewModel
    {
        public bool user_agent { get; set; }
		public string user_web { get; set; }
        public long fb { get; set; }
        public long tw { get; set; }
        public long bn { get; set; }
        public long gog { get; set; }
        public long ax { get; set; }
        public long mysp { get; set; }
        public long volu { get; set; }
        public long mamma { get; set; }
        public long yahoo { get; set; }
        public DateTime date { get; set; }
        public long lycos { get; set; }
        public long youtube { get; set; }
    }
}
